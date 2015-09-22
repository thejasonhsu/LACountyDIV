<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="already-filed.aspx.vb" Inherits="extranet.already_filed" %>
<%@ Register TagPrefix="uc1" TagName="PropertyInfo" Src="propertyaddressinfo.ascx" %>

<div style="text-align: center">
<h1>Decline-in-Value Request for Review</h1>

<h2>Online Filing</h2>
</div>

<uc1:PropertyInfo id="PropertyInfo" runat="server"></uc1:PropertyInfo>			

<div class="DivLeftAlign">
<font color="red">An application has already been filed for this property.</font>
<br /><br />
<a href="./summary.aspx">Click here to review the application</a>
<br /><br />
    <asp:HyperLink id="lnkbtnStatus" Target="_blank" runat="server">Click here to view the status of your <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> decline-in-value review.</asp:HyperLink>
<br />
</div>
<div class="DivLeftAlign">

<font class="FontSmallText">
        <asp:Label ID="lblAssessmentAppealDisagree" EnableViewState="false" runat="server" Text="<%$ Resources:divolf, AssessmentDisagree %>" />            
    </font>
</div>
<div class="DivLeftAlign">
    <font class="FontSmallText">
        <asp:Label ID="lblAssessmentAppealMSG" EnableViewState="false" runat="server" Text="<%$ Resources:divolf, AssessmentAppeals %>" />            
    </font>
</div>
        
<br /><br />
        
<div align="center" >
    <asp:Button ID="BtnBack" runat="server" Text="BACK" CssClass="ButtonStandard" />&nbsp;&nbsp;
</div>