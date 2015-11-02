<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="app-submit.aspx.vb" Inherits="extranet.app_submit" %>
<%@ Register TagPrefix="uc1" TagName="PropertyInfo" Src="propertyaddressinfo.ascx" %>

<div style="text-align: center">
<h1>Decline-in-Value Request for Review</h1>

<h2>Online Filing</h2>
</div>

<uc1:PropertyInfo id="PropertyInfo" runat="server"></uc1:PropertyInfo>			

<div id="DivSubmitMsg" runat="server" visible="false" class="TopRedMsg">
    Please review the following summary for accuracy. <br />
    Your application is not complete until you click SUBMIT below.
</div>

<div id="DivPrintMsg" runat="server" visible="false" class="TopRedMsg">
    Thank you for submitting your <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> decline-in-value application online. <br />
    You will receive notification of the results by email (if provided) and mail.<br />
    <font style="font-weight:normal; font-size:10px;">Please note: the Assessed value (projected) as of January 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" />, shown below, is subject to change.</font>
    <div style="padding: 10 0 0 0">  
    <input id="printSummary" type="button" Value="PRINT THIS SUMMARY" onclick="JavaScript:window.print();" Style="border:lightgrey thin solid;" />
    </div>
</div>  `

<div class="DivFrame">
   
    <div style="padding:10 0 10 0">  
        <table>
            <tr><td align="left" colspan="3"><b>Owner Information:</b></td>
                <td align=right style="color:Red; font-size:9px; width:350px; font-weight:bold;"><asp:Label Visible=false runat="server" id="lblFiledByNDateMsg" />
                
                </td>
            </tr>
            
            <tr><td><div style="width:80px;"></div></td><td align="right"><b>Owner Name:</b></td><td>&nbsp;&nbsp;</td><td class="UserDataText"><asp:Label runat="server" id="lblOwnerName" /></td></tr>
            <tr><td></td><td align="right"><b>Daytime Telephone:</b></td><td>&nbsp;&nbsp;</td><td class="UserDataText"><asp:Label runat="server" id="lblDayTimePhone" /></td></tr>
            <tr>
                <td></td>
                <td align="right"><b>Email Address:</b></td>
                <td>&nbsp;&nbsp;</td>
                <td class="UserDataText"><asp:Label runat="server" id="lblEmailAddress" /></td>
            </tr>
            
            <tr>
                <td></td>
                <td align="right" nowrap><font style="font-size:11px;">Notify me of the results by email:</font></td>
                <td>&nbsp;&nbsp;</td>
                <td class="UserDataText"><asp:Label ID="EmailNotifyOnly" runat="server" /></td>
            </tr>
        
            <tr><td align="left" colspan="4"></td></tr>
            <tr><td align="left" colspan="4"><b>Mailing Address:</b></td></tr>
            
            <tr><td></td><td align="right"><b>Street:</b></td><td>&nbsp;&nbsp;</td><td><asp:Label runat="server" Text="Address" id="lblMailStreet" /></td></tr>
            <tr><td></td><td align="right"><b>City, State Zip</b></td><td>&nbsp;&nbsp;</td><td><asp:Label runat="server" Text="Address" id="lblMailCityStateZip" /></td></tr>
        </table>
    </div>
    
    
    <div><b>Your Property Information:</b></div>
    
    <div> 
        <table>
            <tr><td align="right"><b>Projected Assessed Value as of January 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" />:</b></td><td>&nbsp;&nbsp;</td><td><asp:Label runat="server" id="lblAssessedValue" /></td></tr>
            <tr><td align="right"><b>Your Opinion of Value as of January 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" />:</b></td><td>&nbsp;&nbsp;</td><td class="UserDataText"><asp:Label runat="server" id="lblOpinionValue" /></td></tr>
            <tr><td align="right"><b>Property Type:</b></td><td>&nbsp;&nbsp;</td><td><asp:Label runat="server" id="lblUseType" /></td></tr>
        </table>
    </div>
    
        <div class="DivStandard">
            <asp:Table ID="PropertyCharacter"  CellPadding="5" CellSpacing="0" BorderWidth="0" runat="server">
                <asp:TableRow style="font-size: 10px; font-weight:bold;">
                    <asp:TableCell></asp:TableCell>
                    <asp:TableCell Visible="false">Approx. Sq<br />Footage</asp:TableCell>
                    <asp:TableCell Visible="false">Number of<br />Bedrooms</asp:TableCell>
                    <asp:TableCell Visible="false">Number of<br />Bathrooms</asp:TableCell>
                    <asp:TableCell Visible="false">Number of<br />Units</asp:TableCell>
                </asp:TableRow>
                <asp:TableRow  Visible="false" style="font-size: 10px;">
                    <asp:TableCell style="text-align: right;">Assessor records indicates the following characteristics for<br />your property:</asp:TableCell>
                    <asp:TableCell style="font-weight:bold;"></asp:TableCell>
                    <asp:TableCell style="font-weight:bold;"></asp:TableCell>
                    <asp:TableCell style="font-weight:bold;"></asp:TableCell>
                </asp:TableRow>
                <asp:TableRow>
                    <asp:TableCell Visible="false" style="font-size: 10px; text-align: right;">Indicated Property Characteristics:</asp:TableCell>
                    <asp:TableCell Visible="false" CssClass="UserDataText"></asp:TableCell>
                    <asp:TableCell Visible="false" CssClass="UserDataText"></asp:TableCell>
                    <asp:TableCell Visible="false" CssClass="UserDataText"></asp:TableCell>
                    <asp:TableCell Visible="false" CssClass="UserDataText"></asp:TableCell>
                </asp:TableRow>
            </asp:Table>
            
            <div runat=server id="divPropertyDescription" class="DivDescriptions">
                <asp:label ID="PropertyDescription" runat="server" />    
            </div>
        </div>
    
    
    <div><b>Comparable Sales</b></div>
    
    <div class="DivCompBox">
        <fieldset>
        <legend>Comparable 1:</legend>
             <table style="font-weight:bold; font-size:10px" border=0 >
                <tr>
                    <td>Address </td>
                    <td>City</td>
                    <td>Zip</td>
                    <td>Assessor's ID #</td>
                    <td>Sale Date</td>
                    <td>Sale Price</td>
                </tr>
                <tr style="color: Blue;">
                    <td><asp:Label ID="lblComp1Address" runat="server" /></td>
                    <td><asp:Label ID="lblComp1City" runat="server" /></td>
                    <td><asp:Label ID="lblComp1Zip" runat="server" /></td>
                    <td><asp:Label ID="lblComp1AIN" runat="server" /></td>
                    <td><asp:Label ID="lblComp1Date" runat="server" /></td>
                    <td><asp:Label ID="lblComp1Price" runat="server" /></td>
                </tr>
                <tr>
                    <td colspan="6"><br />Property Description<br />
                        <div class="DivDescriptions">
                            <asp:label ID="tbComp1Desc" runat="server" />
                        </div>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
        <legend>Comparable 2:</legend>
             <table style="font-weight:bold; font-size:10px" border=0 >
                <tr>
                    <td>Address </td>
                    <td>City</td>
                    <td>Zip</td>
                    <td>Assessor's ID #</td>
                    <td>Sale Date</td>
                    <td>Sale Price</td>
                </tr>
                <tr style="color: Blue;">
                    <td><asp:Label ID="lblComp2Address" runat="server" /></td>
                    <td><asp:Label ID="lblComp2City" runat="server" /></td>
                    <td><asp:Label ID="lblComp2Zip" runat="server" /></td>
                    <td><asp:Label ID="lblComp2AIN" runat="server" /></td>
                    <td><asp:Label ID="lblComp2Date" runat="server" /></td>
                    <td><asp:Label ID="lblComp2Price" runat="server" /></td>
                </tr>
            
                <tr>
                    <td colspan="6"><br />Property Description<br />
                        <div class="DivDescriptions">
                            <asp:label ID="tbComp2Desc" runat="server" />
                        </div>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
    
    <div><b>Additional Information:</b></div>
    
    <div class="DivDescriptions">
        <asp:label ID="tbAddtionalInfo" runat="server"  />
    </div>
    <br />
    <div id="DivSubmit" runat="server" visible="false" style="text-align:center; padding: 5 0 10 0;">
        <div style="font-size:12px;color:Red;font-weight:bold; text-align:center; padding: 5 0 10 0;">
            Note: Once you click SUBMIT, you will no longer be able to go back and edit the information you provided
        </div>
        <input type=button id="BACK" name="BACK" title="BACK" value="BACK" class="ButtonStandard" onclick="javascript:history.back();" />
        &nbsp;&nbsp;
        <asp:Button ID="BtnSubmit" runat="server" Text="SUBMIT" CssClass="ButtonStandard" />
    </div>
    
    <div id="DivImportant" runat="server" visible="false">
        <div><asp:Label ID="lblShowImportant" EnableViewState="false" runat="server" Text="<%$ Resources:divolf, ShowImportant %>" /></div>
        <div class="DivStandard">
            <font class="FontSmallText">
                <asp:Label ID="lblKeepACopyMSG" EnableViewState="false" runat="server" Text="<%$ Resources:divolf, KeepACopy %>" />   
            </font>
        </div>
        <div class="DivStandard">
            <font class="FontSmallText">
                <asp:Label ID="lblAssessmentAppealMSG" EnableViewState="false" runat="server" Text="<%$ Resources:divolf, AssessmentAppeals %>" />            
            </font>
        </div>
        <div id="DivFileAnother" style="text-align:center;">
            <asp:Button ID="BtnFileAnother" runat="server" Text="FILE APPLICATION FOR ANOTHER PROPERTY" Style="border:lightgrey thin solid;" />
        </div>
    </div>
    
</div>
