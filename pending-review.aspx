<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="pending-review.aspx.vb" Inherits="extranet.pending_review" %>
<%@ Register TagPrefix="uc1" TagName="PropertyInfo" Src="propertyaddressinfo.ascx" %>
<script type="text/javascript">
    function showMap(sAIN) 
    {
	    document.frames["ShowMapFrame"].location = "http://assessormap.co.la.ca.us/mapping/ShowMap.asp?ain=" + sAIN;
    }
</script>

<iframe id="ShowMapFrame" width="0%" height="0"></iframe>

<div style="text-align: center">
    <h1>Decline-in-Value Request for Review</h1>
    <h2>Online Filing</h2>
</div>

<uc1:PropertyInfo id="PropertyInfo" runat="server"></uc1:PropertyInfo>			


<div>
<font style="color: red;">Your property is currently being reviewed for <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> decline-in-value.  Please check back later for the results.</font>
</div>
<br />
<div>
This review is part of the assessor's initiative to proactively identify properties that have declined in value.  
The review must be completed before you can file a decline-in-value application online.  If you are not satisfied with the resulting value, 
you may return here to request a decline-in-value review.
</div>
<br />
<div id="divEmail" runat="server">
If you wish to be notified by email when the results are available online, enter your email address below:
</div>

<div>
    <div>   
        <table border="0" id="emailTable" runat="server">
            <tr valign="middle">
                <td style="vertical-align:middle;text-align:right;width:35%"><font style="padding-right:5px;font-weight:bold;"> Email:</font></td>
                <td style="vertical-align:middle;text-align:left;width:35%">
                    <asp:TextBox ID="Email" runat="server"  BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="200px" text=""> </asp:TextBox>
                </td>
                <td style="text-align:left;width:30%"></td>
            </tr>
            <tr valign="middle">
                <td style="vertical-align:middle; text-align:right;width:35%"><font style="padding-right:5px;font-weight:bold;font-style:italic;">Confirm Email Address:</font></td>
                <td style="vertical-align:middle;text-align:left;width:35%;vertical-align:middle">
                    <asp:TextBox ID="EmailConfirm" runat="server"  BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="200px" />&nbsp;
                    
                </td>
                <td style="text-align:left;width:30%;vertical-align:middle">
                    <asp:Button id="btnSubmit" runat="server" Text="SUBMIT" Width="60px" />
                </td>
            </tr>
        </table>
        <div style="text-align:center">
            <asp:RegularExpressionValidator runat="server" id="valEmail" ControlToValidate="Email" ErrorMessage="You must provide and confirm an email address in order to be notified via email."  
                            ValidationExpression="^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$" />
            <br />
            <asp:comparevalidator id="cvalEmailConfirm" runat="server" errormessage="Emails does not match" ControlToCompare="Email" ControlToValidate="EmailConfirm"></asp:comparevalidator>
            <br />
            <asp:label id="lblConfirm" runat="server" text=""></asp:label>
            
        </div>
        <br/>
    </div>
    <div align="center" >
        <input type=button id="BACK" name="BACK" title="BACK" value="BACK" class="ButtonStandard" onclick="javascript:history.back();" />
    </div>

</div>