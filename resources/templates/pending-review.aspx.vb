Imports System.Web.Mail
Imports System.IO
Imports LacUtilities


Partial Public Class pending_review
    Inherits LACWebControls.Include.extranetBase
    Dim olf As OnlineFiling

    Protected Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        RequireSSL = True
    End Sub


    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Dim addr As String = ""

        olf = Session("OnlineFiling")
        If (olf Is Nothing) Then
            Response.Redirect("divhome.aspx", True)
        End If
    End Sub


    Protected Sub btnSubmit_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSubmit.Click
        'prc_DIVEmailNotifySet
        Dim mail As MailMessage = New MailMessage()
        Dim message As String
        Dim ain As String = ""
        If Email.Text.Trim() = "" Or EmailConfirm.Text = "" Then
            lblConfirm.Text = "<font color='Red'><b>You must provide and confirm an email address in order to be notified via email.</b></font>"
        Else
            lblConfirm.Text = ""

            olf = Session("OnlineFiling")

            Try
                ain = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AIN").InnerText
                olf.SetEmailNotify(ain, Email.Text.Trim())
                lblConfirm.Text = "<font color='Red'><b>You will receive a confirmation email shortly.</b></font><br>  <a href='./divhome.aspx'>Click here </a> to go to Decline in Value Online filing home page."
                emailTable.Visible = False
                divEmail.Visible = False
                SendEmailPending(Email.Text)

            Catch ex As Exception
                lblConfirm.Text = "Error while saving your email. Contact customer support."
            End Try
        End If

    End Sub

    Protected Sub SendEmailPending(ByVal emailAddress As String)

        Dim emailBody As String
        Dim emailSubject As String
        Dim ain As String = ""

        olf = Session("OnlineFiling")
        ain = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AIN").InnerText

        emailSubject = olf.ReplaceTokens(Resources.divolf.EmailRestorationProactivePendingSubject.ToString(), olf.OnlineFilingXML)

        emailBody = olf.ReplaceTokens(Resources.divolf.EmailRestorationProactivePendingBody.ToString(), olf.OnlineFilingXML)

        olf.SendEmail(emailSubject, emailBody, emailAddress)

    End Sub

End Class