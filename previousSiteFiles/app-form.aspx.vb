Public Partial Class review_form
    Inherits LACWebControls.Include.extranetBase

    Dim olf As OnlineFiling
    Dim opValue As String

    Protected Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        RequireSSL = True
    End Sub

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load

        'EmailNotifyOnly.Attributes.Add("onClick", "EnableCheckBox(this,'" + EmailAddress.ClientID + "','" + EmailConfirm.ClientID + "','" + rEmail1.ClientID + "','" + rEmail2.ClientID + "')")
        'EmailNotifyOnly.Attributes.Add("onClick", "EnableCheckBox(this,'" + EmailAddress.ClientID + "','" + EmailConfirm.ClientID + "')")
        olf = Session("OnlineFiling")
        If (Not olf Is Nothing) Then
            Dim AppStatus As String
            AppStatus = olf.OnlineFilingXML.SelectSingleNode("Application/FilingStatus").InnerText

            ' only allow to file if it's unsubmitted.  Otherwise go to onlinefiling home page.
            If (AppStatus = OnlineFiling.AppStatus.APPUNSUBMITTED) Then
                FillFormInfo()
            Else
                Response.Redirect("divhome.aspx", True)
            End If
        Else

            Response.Redirect("divhome.aspx", True)
        End If
    End Sub

    Protected Sub FillFormInfo()
        Dim strAssessedVal As String
        Dim dAssessedVal As Decimal

        If (Page.IsPostBack = False) Then
            DisplayPropertyTypePanel(olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/UseType").InnerText)

        End If

        lblMailStreet.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Owner/MailingStreet").InnerText
        lblMailCity.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Owner/MailingCity").InnerText
        lblMailState.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Owner/MailingState").InnerText
        lblMailZip.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Owner/MailingZip").InnerText

        strAssessedVal = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AssessedValue").InnerText
        If (Decimal.TryParse(strAssessedVal, dAssessedVal)) Then
            lblAssessedValue1.Text = String.Format("{0:$###,###,###}", dAssessedVal)
        Else
            lblAssessedValue1.Text = "Not Available"
        End If

        lblAssessedValue2.Text = lblAssessedValue1.Text
        lblAssessedValue3.Text = lblAssessedValue1.Text

        If (sfrPanel.Visible) Then ' showing the SFR or CND panel
            lblDBsqFoot.Text = olf.ParcelInfo("SQFTmain").ToString()
            lblDBBedrooms.Text = olf.ParcelInfo("Bedrooms").ToString()
            lblDBBathrooms.Text = olf.ParcelInfo("Bathrooms").ToString()
        End If

    End Sub

    Protected Sub DisplayPropertyTypePanel(ByVal strUserType As String)


        sfrPanel.Visible = False
        riPanel.Visible = False
        ciPanel.Visible = False
        vacPanel.Visible = False
        otPanel.Visible = False

        Select Case strUserType
            Case "SFR", "CND"
                sfrPanel.Visible = True
                ddlPropertyType.Items(0).Value = strUserType
            Case "R-I"
                riPanel.Visible = True
            Case "C/I"
                ciPanel.Visible = True
            Case "VAC"
                vacPanel.Visible = True
            Case "OTH"
                otPanel.Visible = True
        End Select

        ddlPropertyType.SelectedValue = strUserType

    End Sub

    Protected Sub ddlPropertyType_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ddlPropertyType.SelectedIndexChanged
        Dim SelectedType As String = ddlPropertyType.SelectedItem.Value.ToString()
        DisplayPropertyTypePanel(SelectedType)
    End Sub

    Protected Sub BtnCancel_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles BtnCancel.Click
        Response.Redirect("divhome.aspx", True)
    End Sub

    Sub CustomValidator1_ServerValidate(ByVal source As Object, ByVal args As ServerValidateEventArgs)
        args.IsValid = ConfirmInfo.Checked
    End Sub

    Sub cvalOwnerName_ServerValidate(ByVal source As Object, ByVal args As ServerValidateEventArgs)
        If OwnerName.Text.Trim() = "" Then
            args.IsValid = False
        End If
    End Sub

    Sub cvalOpinionValue_ServerValidate(ByVal source As Object, ByVal args As ServerValidateEventArgs)
        'Dim opValue As String
        If OpinionValue.Text.Trim() = "" Then
            args.IsValid = False
        Else
            opValue = OpinionValue.Text.Replace(",", "")
        End If

    End Sub

    Protected Sub BtnNext_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles BtnNext.Click
        Dim strUserType As String = ddlPropertyType.SelectedValue
        Dim strAIN As String = ""
        Dim strRedirectPage = ""
        'If (ConfirmInfo.Checked = False) Then
        '    Dim strScript As String = "<script language=javascript> var ConfirmInfo = document.getElementById('" + ConfirmInfo.ClientID + "')"
        '    strScript += "alert(ConfirmInfo.checked);"
        '    strScript += "if(ConfirmInfo.checked == false)"
        '    strScript += "{ alert('Select checkbox to acknowledge all information you is correct.'); }"
        '    strScript += "</" + "script>"
        '    If Page.IsClientScriptBlockRegistered("confirm") Then
        '        Page.RegisterStartupScript("confirm", strScript)
        '    End If
        '    Exit Sub
        'End If
        'BtnNext.Attributes.Add("onclick", strScript)

        If EmailAddress.Text.Trim() <> EmailConfirm.Text.Trim() Then
            If Page.IsValid Then
                lblError.Text = "Please provide and confirm Email Address."
            Else
                lblError.Text = "<i>You must provide all required fields (Owner Name and your Opinion of Value) and<br>confirm that you are the owner before proceeding."
                lblError.Text += "<br>Please provide and confirm Email Address."
                lblError.Text += "<br><br> * Required fields </i>"
            End If
            lblError.Visible = True
            lblCErr.Text = "**"
            Exit Sub
        End If


        lblError.Visible = False
        If Page.IsValid = False Then
            lblError.Visible = True
            Exit Sub
        End If

        Try
            'Save the data into the XML
            strAIN = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AIN").InnerText()
            olf.OnlineFilingXML.SelectSingleNode("Application/Owner/AssesseeName").InnerText = OwnerName.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/Owner/DayTimePhone").InnerText = DayTimePhone.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/Owner/EmailAddress").InnerText = EmailAddress.Text.Trim()
            'olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/OpinionValue").InnerText = OpinionValue.Text.Trim()

            Dim pos As Integer
            pos = InStr(1, opValue.Trim(), ".")
            If pos > 0 Then
                Dim OpinionVal As String = opValue.Trim().Substring(0, pos - 1)
                olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/OpinionValue").InnerText = OpinionVal
            Else
                olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/OpinionValue").InnerText = opValue.Trim() 'OpinionValue.Text.Trim()
            End If

            If (EmailAddress.Text.Trim() <> "") Then
                olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/EmailNotify").InnerText = "Y"
            Else
                olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/EmailNotify").InnerText = "N"
            End If

            olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/UseType").InnerText = ddlPropertyType.SelectedValue

            'check the property type and and put info into XML base on that
            Select Case ddlPropertyType.SelectedValue
                Case "SFR", "CND"
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/SQFTmain").InnerText = sfrFootage.Text.Trim()
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Bedrooms").InnerText = sfrBedrooms.Text.Trim()
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Bathrooms").InnerText = sfrBathrooms.Text.Trim()
                Case "R-I"
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/SQFTmain").InnerText = riFootage.Text.Trim()
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Bedrooms").InnerText = riBedrooms.Text.Trim()
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Bathrooms").InnerText = riBathrooms.Text.Trim()
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Units").InnerText = riUnits.Text.Trim()
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Description").InnerText = riIncomeInfo.Text.Trim()
                Case "C/I"
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/SQFTmain").InnerText = ciFootage.Text.Trim()
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Units").InnerText = ciUnits.Text.Trim()
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Description").InnerText = ciIncomeInfo.Text.Trim()
                Case "VAC"
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Description").InnerText = vacInfo.Text.Trim()
                Case "OTH"
                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Description").InnerText = otInfo.Text.Trim()
            End Select

            ' Store Comparable Sales information in XML
            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/Address").InnerText = CompSale1Address.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/City").InnerText = CompSale1City.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/Zip").InnerText = CompSale1Zip.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/AIN").InnerText = CompSale1AIN.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/SaleDate").InnerText = CompSale1Date.Text.Trim()
            'olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/SalePrice").InnerText = CompSale1Price.Text.Trim()

            Dim CompSale1Price1 As String
            CompSale1Price1 = CompSale1Price.Text.Replace(",", "")

            pos = InStr(1, CompSale1Price1.Trim(), ".")
            If pos > 0 Then
                Dim NewSalePrice1 As String = CompSale1Price1.Trim().Substring(0, pos - 1)
                olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/SalePrice").InnerText = NewSalePrice1
            Else
                olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/SalePrice").InnerText = CompSale1Price1.Trim()
            End If

            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/Description").InnerText = CompSale1Desc.Text.Trim()

            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/Address").InnerText = CompSale2Address.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/City").InnerText = CompSale2City.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/Zip").InnerText = CompSale2Zip.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/AIN").InnerText = CompSale2AIN.Text.Trim()
            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/SaleDate").InnerText = CompSale2Date.Text.Trim()
            'olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/SalePrice").InnerText = CompSale2Price.Text.Trim()

            Dim CompSale2Price2 As String
            CompSale2Price2 = CompSale2Price.Text.Replace(",", "")

            pos = InStr(1, CompSale2Price2.Trim(), ".")
            If pos > 0 Then
                Dim NewSalePrice2 As String = CompSale2Price2.Trim().Substring(0, pos - 1)
                olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/SalePrice").InnerText = NewSalePrice2
            Else
                olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/SalePrice").InnerText = CompSale2Price2.Trim()
            End If

            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/Description").InnerText = CompSale2Desc.Text.Trim()

            olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/AddtionalInfo").InnerText = AdditionalInfo.Text.Trim()
            strRedirectPage = "app-submit.aspx"

        Catch ex As Exception
            Dim logHandler As LacUtilities.Logger
            Dim urlReferrer As String = ""
            Dim strDesc = ""
            If Not (Request.UrlReferrer Is Nothing) Then
                urlReferrer = Request.UrlReferrer.ToString()
            End If

            logHandler = New LacUtilities.Logger("Extranet Website", ConfigurationManager.AppSettings("DSN"), False, Nothing, LacUtilities.Logger.MessageType.Information, _
                                        ConfigurationManager.AppSettings("EmailServer"), "webmaster@assessor.lacounty.gov", Nothing, _
                                        ConfigurationManager.AppSettings("siteDownNotificationList"))

            strDesc = "AIN=" & strAIN & "\r\n" & " QueryString=" & Request.RawUrl & "\r\n" & "Stacktrace: " + ex.StackTrace
            logHandler.LogWebException(Request.UserHostAddress, urlReferrer, _
                                Request.Url.ToString(), ex.Message, _
                                Request.ServerVariables("HTTP_HOST"), Request.UserAgent, _
                                strDesc)
            strRedirectPage = "divhome.aspx"
        Finally
            Response.Redirect(strRedirectPage, True)
        End Try


    End Sub

    'Protected Sub EmailNotifyOnly_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles EmailNotifyOnly.CheckedChanged
    '    Dim val As Boolean
    '    val = ValidateEmail()
    'End Sub

    'Private Function ValidateEmail() As Boolean
    '    Dim retVal As Boolean
    '    If (EmailAddress.Text.Trim() <> "" And EmailConfirm.Text.Trim() = "") Then
    '        rvalEmailConfirm.Enabled = True
    '        Return (False)
    '    Else
    '        rvalEmailConfirm.Enabled = False
    '    End If

    '    If (EmailAddress.Text.Trim() = "" And EmailConfirm.Text.Trim() <> "") Then
    '        rvalEmail.Enabled = True
    '        Return (False)
    '    Else
    '        rvalEmail.Enabled = False
    '    End If

    '    If EmailNotifyOnly.Checked And (EmailAddress.Text.Trim() = "" Or EmailConfirm.Text.Trim() = "") Then
    '        rvalEmail.Enabled = True
    '        rvalEmailConfirm.Enabled = True
    '        Return (False)
    '    Else
    '        rvalEmail.Enabled = False
    '        rvalEmailConfirm.Enabled = False
    '        Return (True)
    '    End If
    'End Function
End Class