Public Partial Class propertyaddressinfo
    Inherits System.Web.UI.UserControl
    Dim olf As OnlineFiling

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        olf = Session("OnlineFiling")
        If (Not olf Is Nothing) Then
            lblPropertyAddress.Text = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/SitusStreet").InnerText & " " & _
                                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/SitusCity").InnerText & " " & _
                                    olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/SitusZip").InnerText
            Dim strAIN As String = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AIN").InnerText
            lblAIN.Text = String.Format("{0}-{1}-{2}", _
                    strAIN.Substring(0, 4), _
                    strAIN.Substring(4, 3), _
                    strAIN.Substring(7))

            lblAIN.Text += "&nbsp;&nbsp;&nbsp;<a href='javascript:showMap(" + strAIN + ")'><font color='#FFFF00'>View Map</font></a>"


        End If


    End Sub

End Class