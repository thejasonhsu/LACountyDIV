<%@ Control Language="vb" AutoEventWireup="false" CodeBehind="propertyaddressinfo.ascx.vb" Inherits="extranet.propertyaddressinfo" %>
<script type="text/javascript">
    function showMap(sAIN) 
    {
//        alert("hello");
	    document.frames["ShowMapFrame"].location = "http://assessormap.co.la.ca.us/mapping/ShowMap.asp?ain=" + sAIN;

    }
</script>
<iframe id="ShowMapFrame" width="0%" height="0"></iframe>
<div class="DivAddressInfo">
    <table style="color:White;">
        <tr>
            <td style="font-weight:bold;">Property Address:</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><asp:Label runat="server" Text="Address" id="lblPropertyAddress" /></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">AIN:</td>
            <td></td>
            <td><asp:Label runat="server" Text="Address" id="lblAIN" /> </td>
        </tr>
    </table>
</div>