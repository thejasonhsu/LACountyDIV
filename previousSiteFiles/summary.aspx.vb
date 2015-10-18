Partial Public Class summary
    Inherits LACWebControls.Include.extranetBase

    Dim olf As OnlineFiling

    Protected Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        RequireSSL = True
    End Sub

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Dim AppStatus As String

        olf = Session("OnlineFiling")
        If (Not olf Is Nothing) Then
            Dim strAIN As String = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AIN").InnerText
        Else
            Response.Redirect("divhome.aspx", True)
        End If

        DisplaySummary()

    End Sub

    Protected Sub DisplaySummary()
        Dim strUseType As String
        Dim dVal As Decimal
        Dim strRequestor = olf.OnlineFilingXML.SelectSingleNode("Application/Requestor").InnerText
        Dim strFilingMethod = olf.OnlineFilingXML.SelectSingleNode("Application/FilingMethod").InnerText
        Dim strAssessedVal As String = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/AssessedValue").InnerText

        lblOwnerName.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Owner/AssesseeName").InnerText
        lblDayTimePhone.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Owner/DayTimePhone").InnerText
        lblEmailAddress.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Owner/EmailAddress").InnerText

        If (Decimal.TryParse(strAssessedVal, dVal)) Then
            lblAssessedValue.Text = String.Format("{0:$###,###,###}", dVal)
        Else
            lblAssessedValue.Text = "Not Available"
        End If

        dVal = System.Convert.ToDecimal(olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/OpinionValue").InnerText)
        lblOpinionValue.Text = String.Format("{0:$###,###,###}", dVal)

        lblMailStreet.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Owner/MailingStreet").InnerText
        lblMailCityStateZip.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Owner/MailingCity").InnerText & " " & _
                                    olf.OnlineFilingXML.SelectSingleNode("Application/Owner/MailingState").InnerText & ", " & _
                                    olf.OnlineFilingXML.SelectSingleNode("Application/Owner/MailingZip").InnerText

        If (strFilingMethod = "Online") Then
            lblFiledByNDateMsg.Text = "Filed Online: " & olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/SubmitDate").InnerText
        Else
            lblFiledByNDateMsg.Text = "Filed by " & strFilingMethod & ": " & olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/SubmitDate").InnerText
        End If

        ' Agent info, only show if Requestor is Agent.
        If (strRequestor = "Agent") Then
            AgentInfo.Visible = True
            lblAgentName.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Agent/Name").InnerText
            lblAgentPhone.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Agent/DayTimePhone").InnerText
            lblAgentEmailAddress.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Agent/EmailAddress").InnerText
            lblAgentMailStreet.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Agent/MailingStreet").InnerText
            lblAgentCityStateZip.Text = olf.OnlineFilingXML.SelectSingleNode("Application/Agent/MailingCity").InnerText & " ," & _
                                olf.OnlineFilingXML.SelectSingleNode("Application/Agent/MailingState").InnerText & " " & _
                                olf.OnlineFilingXML.SelectSingleNode("Application/Agent/MailingZip").InnerText
        End If

        strUseType = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/UseType").InnerText
        lblUseType.Text = olf.ResolveUseType(strUseType)
        EmailNotifyOnly.Text = IIf(olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/EmailNotify").InnerText = "Y", "Yes", "No")

        Select Case strUseType
            Case "CND", "SFR"
                ' heading
                PropertyCharacter.Rows(0).Cells(1).Visible = True
                PropertyCharacter.Rows(0).Cells(2).Visible = True
                PropertyCharacter.Rows(0).Cells(3).Visible = True

                ' SFR CND only, Disply DB values
                PropertyCharacter.Rows(1).Visible = True

                PropertyCharacter.Rows(1).Cells(1).Text = olf.ParcelInfo("SQFTmain").ToString()
                PropertyCharacter.Rows(1).Cells(2).Text = olf.ParcelInfo("Bedrooms").ToString()
                PropertyCharacter.Rows(1).Cells(3).Text = olf.ParcelInfo("Bathrooms").ToString()

                ' user values
                PropertyCharacter.Rows(2).Cells(0).Visible = True
                PropertyCharacter.Rows(2).Cells(1).Visible = True 'sqfoot
                PropertyCharacter.Rows(2).Cells(2).Visible = True 'Bedroom
                PropertyCharacter.Rows(2).Cells(3).Visible = True 'bathroom

                divPropertyDescription.Visible = False
            Case "R-I"
                ' heading
                PropertyCharacter.Rows(0).Cells(1).Visible = True
                PropertyCharacter.Rows(0).Cells(2).Visible = True
                PropertyCharacter.Rows(0).Cells(3).Visible = True
                PropertyCharacter.Rows(0).Cells(4).Visible = True

                ' user values
                PropertyCharacter.Rows(2).Cells(0).Visible = True
                PropertyCharacter.Rows(2).Cells(1).Visible = True 'sqfoot
                PropertyCharacter.Rows(2).Cells(2).Visible = True 'Bedroom
                PropertyCharacter.Rows(2).Cells(3).Visible = True 'bathroom
                PropertyCharacter.Rows(2).Cells(4).Visible = True 'unit
            Case "C/I"
                ' heading
                PropertyCharacter.Rows(0).Cells(1).Visible = True
                PropertyCharacter.Rows(0).Cells(4).Visible = True

                ' user values
                PropertyCharacter.Rows(2).Cells(0).Visible = True
                PropertyCharacter.Rows(2).Cells(1).Visible = True 'sqfoot
                PropertyCharacter.Rows(2).Cells(4).Visible = True 'unit
        End Select

        PropertyCharacter.Rows(2).Cells(1).Text = IIf(olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/SQFTmain").InnerText <> "", olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/SQFTmain").InnerText, "-")
        PropertyCharacter.Rows(2).Cells(2).Text = IIf(olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Bedrooms").InnerText <> "", olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Bedrooms").InnerText, "-")
        PropertyCharacter.Rows(2).Cells(3).Text = IIf(olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Bathrooms").InnerText <> "", olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Bathrooms").InnerText, "-")
        PropertyCharacter.Rows(2).Cells(4).Text = IIf(olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Units").InnerText <> "", olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Units").InnerText, "-")
        PropertyDescription.Text = olf.OnlineFilingXML.SelectSingleNode("Application/PDBParcel/Description").InnerText

        lblComp1AIN.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/AIN").InnerText
        lblComp1Address.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/Address").InnerText
        lblComp1City.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/City").InnerText
        lblComp1Zip.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/Zip").InnerText
        lblComp1Date.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/SaleDate").InnerText
        If (Decimal.TryParse(olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/SalePrice").InnerText, dVal)) Then
            lblComp1Price.Text = String.Format("{0:$###,###,###}", dVal)
        End If
        tbComp1Desc.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=1]/Description").InnerText

        lblComp2AIN.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/AIN").InnerText
        lblComp2Address.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/Address").InnerText
        lblComp2City.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/City").InnerText
        lblComp2Zip.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/Zip").InnerText
        lblComp2Date.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/SaleDate").InnerText
        If (Decimal.TryParse(olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/SalePrice").InnerText, dVal)) Then
            lblComp2Price.Text = String.Format("{0:$###,###,###}", dVal)
        End If
        tbComp2Desc.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/Comparables/Property[@Sale=2]/Description").InnerText

        tbAddtionalInfo.Text = olf.OnlineFilingXML.SelectSingleNode("Application/UserInput/AddtionalInfo").InnerText

    End Sub

End Class

