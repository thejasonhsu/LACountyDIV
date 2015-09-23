Public Partial Class NoFiling
    Inherits LACWebControls.Include.extranetBase

    Dim olf As OnlineFiling

    Protected Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        RequireSSL = True
    End Sub

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Dim intAppStatus As Int16
        Dim ain As String = ""
        Dim assessedValue As String = ""
        olf = Session("OnlineFiling")


        If (Not olf Is Nothing) Then

            intAppStatus = olf.OnlineFilingXML.SelectSingleNode("Application/FilingStatus").InnerText
            ain = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AIN").InnerText
            assessedValue = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AssessedValue").InnerText
            Dim Year As Integer
            Year = DateTime.Today.Year

            Select Case intAppStatus
                Case OnlineFiling.AppStatus.APPNEW, OnlineFiling.AppStatus.APPREVIEWED
                    'show links
                    lblMessage.Text = "<font color='Red'>An Application has already been filed for this property.</font><br/><br/>" _
                                    + "<a href='./summary.aspx'>Click here to review your " & Year & " application.</a><br/><br/>" _
                                    + "<a href='../guides/prop8status.aspx?AIN=" + ain + "'>Click here to view the status of your " & Year & " decline-in-value review.</a><br/><br/>"
                Case Else
                    Session.Remove("OnlineFiling")
                    lblMessage.Text = "<font color='Black'>Your Projected " & Year & " assessed value is $" + assessedValue + ". Your " & Year & "-" & Year + 1 & " taxes will be based on this value.</font><br/><br/>"

                    ' show current assessed value message
            End Select
        Else
            Session.Remove("OnlineFiling")
            Response.Redirect("divhome.aspx", True)
        End If

    End Sub


End Class