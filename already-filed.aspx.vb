Public Partial Class already_filed
    Inherits LACWebControls.Include.extranetBase
    Dim olf As OnlineFiling

    Protected Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        RequireSSL = True
    End Sub

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Dim url As String = "../guides/prop8status.aspx"
        Dim ain As String = ""

        olf = Session("OnlineFiling")

        If (Not olf Is Nothing) Then
            ain = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AIN").InnerText
        Else
            Response.Redirect("divhome.aspx", True)
        End If

        url += "?AIN=" + ain
        lnkbtnStatus.NavigateUrl = url

    End Sub

    Protected Sub BtnBack_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles BtnBack.Click
        Response.Redirect("divhome.aspx", True)
    End Sub

End Class