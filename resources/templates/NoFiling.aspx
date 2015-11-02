<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="NoFiling.aspx.vb" Inherits="extranet.NoFiling" %>
<%@ Register TagPrefix="uc1" TagName="PropertyInfo" Src="propertyaddressinfo.ascx" %>

<div style="text-align: center">
<h1>Decline-in-Value Request for Review</h1>

<h2>Online Filing</h2>
</div>

<uc1:PropertyInfo id="PropertyInfo" runat="server"></uc1:PropertyInfo>			


<br /><br />
<div class="DivStandard">
    <font style="color:black; ">
        The filing period for a <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> Decline-in-Value request for review has expired. <br /><br />
        Requests for a <b><asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /></b> Decline-in-Value Review will be accepted between <b>July 2 and December 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" />.</b><br /><br />
        Visit our <a href="/extranet/guides/prop8.aspx">Property Owner's Guide to Deline-in-Value</a> webpage for more information.<br /><br /><br />
    </font>
    
    <asp:label id="lblMessage" runat="server" text="" />
    
</div>

