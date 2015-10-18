Imports Lanap.BotDetect


Partial Public Class home
    Inherits LACWebControls.Include.extranetBase

    Public m_FilingYear As String = ""

    Protected Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init

        ' modified on 11/25/13: for DIV period
        ' redirect to homepage in case user goes to this page
        ' remove redirect for July 2 when DIV filing starts
        'Response.Redirect(ResolveUrl("/extranet/decline/overview.aspx"), True)

        'register CAPTCHA-specific event handler
        'RequireSSL = True
        m_FilingYear = Resources.divolf.FilingYear.ToString()
        AddHandler SampleCaptcha.PreDrawCaptchaImage, AddressOf SampleCaptcha_PreDrawCaptchaImage
    End Sub

    Protected Sub Page_PreRender(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.PreRender

        ' initial page setup
        If (Not IsPostBack) Then
            MessageIncorrectLabel.Text = ""
            'these messages are shown only after validation
            MessageIncorrectLabel.Visible = False
        End If


        ' clear user input on Reload button clicks
        Dim scriptTemplate As String
        scriptTemplate = "function LBD_ClearUserInput() {{" & _
            "   var LBD_textBox = document.getElementById('{0}');" & _
            "   if(LBD_textBox) {{" & _
            "       LBD_textBox.value = '';" & _
            "   }}" & _
            "}}" & _
            "LBD_RegisterHandler('PreReloadCaptchaImage', LBD_ClearUserInput);"

        Dim script As String
        script = String.Format(scriptTemplate, CodeTextBox.ClientID)
        If (Not Page.ClientScript.IsStartupScriptRegistered("CaptchaReloadClearInput")) Then
            Page.ClientScript.RegisterStartupScript(Me.GetType(), "CaptchaReloadClearInput", script, True)
        End If

        ' automatically lowercase user input
        CodeTextBox.Attributes.Add("onkeyup", "this.value = this.value.toLowerCase();")

        If (IsPostBack) Then
            'validate the input code, and show the appropriate message 
            Dim code As String = CodeTextBox.Text.Trim().ToUpper()

            If (SampleCaptcha.Validate(code)) Then
                Dim strAIN As String = Request("AIN")
                Dim strPIN As String = Request("PIN")

                strAIN = strAIN.Trim().Replace("-", "").Replace(" ", "").TrimStart("0")
                MessageIncorrectLabel.Text = ""
                MessageIncorrectLabel.Visible = False
                lblErrorAINPIN.Text = ""
                lblErrorAINPIN.Visible = False

                If ValidateAINPIN(strAIN, strPIN) Then
                    ParcelRedirect(strAIN)
                Else
                    'Display Error
                    lblErrorAINPIN.Text = "Invalid AIN and/or PIN.  Please try again with the AIN (10 digits) and PIN."
                    lblErrorAINPIN.Visible = True
                End If
            Else
                MessageIncorrectLabel.Text = "Entered code does not match with displayed code, try again!"
                MessageIncorrectLabel.Visible = True
            End If

            'clear previous user code input
            CodeTextBox.Text = ""
        End If

    End Sub

    Protected Sub ParcelRedirect(ByVal strAIN As String)
        Dim olf As OnlineFiling
        Dim intAppStatus As Int16

        olf = New OnlineFiling()
        olf.LoadApplication(strAIN)

        Session("OnlineFiling") = olf
        intAppStatus = olf.OnlineFilingXML.SelectSingleNode("Application/FilingStatus").InnerText
        ' check App Status
        Try
            'Check if the Parcel is Active or not
            If (olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/ParcelStatus").InnerText.ToUpper() <> "(ACTIVE)") Then
                If (strAIN.StartsWith("89")) Then ' check for 89XX Map book
                    MessageIncorrectLabel.Text = Resources.divolf.ParcelType89xx.ToString()
                Else
                    MessageIncorrectLabel.Text = Resources.divolf.ParcelChange.ToString()
                End If
                MessageIncorrectLabel.Visible = True
            Else

                ' check if we're in filing period 7/2 - 11/30
                If DateTime.Compare(DateTime.Today, DateTime.Parse(GetGlobalResourceObject("divolf", "FilingPeriodBegin"))) > 0 And _
                                DateTime.Compare(DateTime.Today, DateTime.Parse(GetGlobalResourceObject("divolf", "FilingPeriodEnd"))) <= 0 Then

                    Select Case intAppStatus
                        Case OnlineFiling.AppStatus.APPPROACTIVE
                            Response.Redirect("pending-review.aspx", True)
                        Case OnlineFiling.AppStatus.APPUNSUBMITTED
                            Response.Redirect("app-form.aspx", True)
                        Case OnlineFiling.AppStatus.APPNEW, OnlineFiling.AppStatus.APPREVIEWED
                            Response.Redirect("already-filed.aspx", True)
                        Case Else
                            Response.Redirect("pending-review.aspx", True)

                    End Select
                Else
                    ' outside filing period
                    Response.Redirect("NoFiling.aspx")
                End If
            End If
        Catch ex As Exception

        End Try

    End Sub

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load


        'Dim url As String = Request.Url.ToString()
        'If url.Contains("http://") Then
        '    Dim redirectURL As String = "https://" + url.Substring(7)
        '    Response.Redirect(redirectURL, False)
        'End If

        '"https://localhost/extranet/onlinefiling/home.aspx"
        'Response.Redirect(url)

        'Dim valScript As String = "if (event.keyCode == 13) { "
        'valScript += "      alert('xxxxxxxx');"
        ''valScript += "  document.forms[0]." + goBtn.ClientID + ".click(); "
        ''valScript += "  return false; "
        'valScript += "} "
        'goBtn.Attributes.Add("onKeyPress", valScript)
        'goBtn.Attributes.Add("onKeyPress", "if ( event.keyCode == 13 ) { alert('Please GO button'); }")

			
    End Sub

    'Protected Sub goBtn_Click(ByVal sender As System.Object, ByVal e As System.Web.UI.ImageClickEventArgs) Handles goBtn.Click
    '    Dim strAIN As String = Request("AIN")
    '    Dim strPIN As String = Request("PIN")
    '    Dim olf As OnlineFiling
    '    strAIN = strAIN.Trim().Replace("-", "").TrimStart("0")

    '    If ValidateAINPIN(strAIN, strPIN) Then

    '        olf = New OnlineFiling(strAIN)

    '        Session("OnlineFiling") = olf
    '    Else
    '        'Display Error
    '    End If

    'End Sub

    'all CAPTCHA randomization should be performed in this event handler instead of Page_Load 
    'or Page_PreRender, because this event is also fired for direct CAPTCHA image requests
    '(which skip the page events since the page is never loaded), for example when clicking 
    'the Reload CAPTCHA button repeatedly
    Protected Sub SampleCaptcha_PreDrawCaptchaImage(ByVal sender As System.Object, ByVal e As System.EventArgs)
        Dim captcha As ICaptcha = sender
        If (captcha.CaptchaId <> SampleCaptcha.CaptchaId) Then
            Return
        End If

        ' randomize code generation properties
        captcha.CodeType = RandomizationHelper.GetRandomCodeType()
        captcha.CodeLength = RandomizationHelper.GetRandomCodeLength(5, 6)

        ' randomize text style
        Dim styles As TextStyleEnum() = { _
            TextStyleEnum.Lego, TextStyleEnum.MeltingHeat, TextStyleEnum.Ghostly, _
            TextStyleEnum.FingerPrints, TextStyleEnum.Graffiti2, TextStyleEnum.Bullets2, _
            TextStyleEnum.CaughtInTheNet2, TextStyleEnum.Collage, TextStyleEnum.Chalkboard _
        }

        captcha.TextStyle = RandomizationHelper.GetRandomTextStyle(styles)

    End Sub

    Protected Function ValidateAINPIN(ByVal strAIN As String, ByVal strPIN As String) As Boolean

        Dim bizClass As New OnlineFiling()
        Dim iValue As Long
        Dim tAIN As String = ""
        If strAIN.Trim().Contains(" ") Then
            tAIN = strAIN.Replace(" ", "")
            strAIN = tAIN
        End If
        If strAIN.Length > 10 Then
            strAIN = strAIN.Substring(0, 10)
        End If

        Try

            If strAIN.Length <> 10 Then
                Return False
            End If
            If strPIN.Length <> 6 Then
                Return False
            End If
            iValue = Convert.ToInt64(strAIN)
            'iValue = Convert.ToInt32(strPIN)
        Catch ex As Exception
            Return False
        End Try
        Return bizClass.Validate(strAIN, strPIN)

    End Function
End Class

