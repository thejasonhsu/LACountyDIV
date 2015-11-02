<%@ Page Language="vb" AutoEventWireup="true" CodeBehind="app-form.aspx.vb" MaintainScrollPositionOnPostBack="true" Inherits="extranet.review_form" %>
<%@ Register TagPrefix="uc1" TagName="PropertyInfo" Src="propertyaddressinfo.ascx" %>

<script language="javascript">
    function MaxLimit(txt,maxLen){
        try{
            if(txt.value.length > (maxLen-1))
            {   
                txt.value = txt.value.substring(0,maxLen)
                return false;
            }
           }catch(e){}
    }

    function EnableCheckBox(chk,txt1,txt2){
                var temail = document.forms[0].elements[txt1];
                var vemail = document.forms[0].elements[txt2];
                var val1 = document.forms[0].elements[txt2].value;
                var val2 = document.forms[0].elements[txt2].value;
                
                if(temail.value.length < 1 || vemail.value.length < 1)
                {
                    chk.checked = false;
                    alert("Please provide and confirm Email Address before checking notify by email.");
                }
                if( val1!= val2 )
                {
                    chk.checked = false;
                    alert("Please provide and confirm Email Address before checking notify by email.");
                }
                return true;
    }
</script>

<div style="text-align: center">
<h1>Decline-in-Value Request for Review</h1>

<h2>Online Filing</h2>
</div>

<uc1:PropertyInfo id="PropertyInfo" runat="server"></uc1:PropertyInfo>			


<div style="font-size:12px; color:Red; padding: 5 0 5 0">
Your projected <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> assessed value is <b><asp:Label runat="server" Text="" ID="lblAssessedValue1" /></b>.  Your <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, TaxYear %>" /> taxes will be based on this value.<br />
</div>

<div style="font-size:12px; color:Red; padding: 5 0 5 0">
<%--If you believe the market value of your property as of January 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> is less than <b><asp:Label runat="server" Text="" ID="lblAssessedValue3" /></b> , please complete the online form below (or <a href="http://assessor.lacounty.gov/extranet/lac/control/binaryGet.aspx?uploadid=731">click here to file by mail</a>).
--%>
If you believe the market value of your property as of January 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> is less than <b><asp:Label runat="server" Text="" ID="lblAssessedValue3" /></b> , please complete the online form below (or <a href="http://ezforms.assessor.lacounty.gov/Form/Fill/15" target="_blank">click here to file by mail</a>).
</div>

<div style="font-size:12px; padding: 5 0 5 0; font-weight:bold;">
Important: This application MUST be filed between <font style="color: red;">July 2 and November 30, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /></font>. 
</div>

<div style="font-size:9px; padding: 5 0 5 0;">
The California Revenue and Taxation Code allows for a temporary reduction in assessed value when property suffers a "decline-in-value." 
A decline-in-value occurs when the market value of your property is less than the assessed value as of January 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" />. 
</div>

<div class="DivFrame">
    <div>
        <div style="float:left;"><b>Owner Information:</b></div>
        <div style="float:right"><font style="text-align:right;font-size: 8.5pt;color: Red;font-family: Verdana, Arial;"> * Required fields</font></div>
        <br />
    </div>
    <table style ="width:99%" border=0>
    <tr><td style ="width:30%;text-align:right;"><font style="padding-right:10px; font-weight:bold;"><font color="red">*</font>Owner Name: &nbsp;</font></td>
        <td style ="width:70%;"><asp:TextBox ID="OwnerName" runat="server"  maxlength="50"  BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="250px" />
        
        <asp:CustomValidator id="cvalOwnerName" runat="server" ErrorMessage="**" OnServerValidate="cvalOwnerName_ServerValidate"> </asp:CustomValidator>
        
		<asp:RegularExpressionValidator runat="server" id="valOwnerName" ControlToValidate="OwnerName" ErrorMessage="Invalid characters"  
            ValidationExpression="^[A-Za-z0-9\.\;\:\#\!\@\&\,\?\~/'-_\s]{1,50}$" /></td>
    </tr>
    <tr><td style ="width:30%;text-align:right"><font style="padding-right:10px; font-weight:bold;">Daytime Telephone:</font></td>
        <td style ="width:70%;"><asp:TextBox ID="DayTimePhone" runat="server" maxlength="20" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="150px" />
    </tr>
    <tr height="7"><td colspan="2" height="7"></td></tr>
    <tr><td colspan="2" style="text-align:left"><font style="font-weight:bold;">Notify Me Of The Results By Email:</font>
        <font style="padding-right:262px;">&nbsp;</font></td></tr>
        
    <tr><td style ="width:30%;text-align:right"><font style="padding-right:10px;font-weight:bold;">Email Address:</font></td>
        <td style ="width:70%;">
            <asp:TextBox ID="EmailAddress" text="" runat="server"  BorderColor="DarkGray"  maxlength="50"  BorderStyle="Solid" BorderWidth="1px" Width="250px" />&nbsp;
            <asp:RegularExpressionValidator runat="server" id="valEmail" ControlToValidate="EmailAddress" ErrorMessage="Invalid Email" ValidationExpression="^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$" />
        </td>
    </tr>
    <tr><td style ="width:30%;text-align:right"><font style="padding-right:10px; font-size:11px;">Confirm Email Address:</font></td>
        <td style ="width:70%;">
            <asp:TextBox ID="EmailConfirm" runat="server"  text="" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="250px" />&nbsp; <asp:Label runat="server" Text="" ID="lblCErr" style="color:Red;" />
    </td></tr>
    
    <tr><td style ="width:30%;text-align:right"><font style="padding-right:10px; font-size:11px;"></font></td>
        <td style ="width:70%;">
        <asp:comparevalidator id="cvalEmailConfirm" runat="server" errormessage="Emails does not match" ControlToCompare="EmailAddress" ControlToValidate="EmailConfirm"></asp:comparevalidator>
        </td></tr>
    </table>
    
    <hr />
    
    <div><b>Mailing Address on File: </b></div>
    
    <div style="height:100px">
<%--        <div style="float:left;font-size:11px; padding-top:20px;"><a href="javascript:newwindow=window.open('http://assessor.lacounty.gov/extranet/lac/control/binaryget.aspx?uploadid=187','AddressChange');if (window.focus) {newwindow.focus();}"> Click here for a change of<br />mailing address form</a></div>
--%>        
            <div style="float:left;font-size:11px; padding-top:20px;"><a href="javascript:newwindow=window.open('http://ezforms.assessor.lacounty.gov/Form/Fill/10','AddressChange');if (window.focus) {newwindow.focus();}"> Click here for a change of<br />mailing address form</a></div>
            <div style="float:right; width:350px;"> 
            <table>
                <tr><td align="right"><b>Street:</b></td><td>&nbsp;&nbsp;</td><td><asp:Label runat="server" Text="Address" ID="lblMailStreet" /></td></tr>
                <tr><td align="right"><b>City:</b></td><td>&nbsp;&nbsp;</td><td><asp:Label runat="server" Text="Address" ID="lblMailCity" /></td></tr>
                <tr><td align="right"><b>State:</b></td><td>&nbsp;&nbsp;</td><td><asp:Label runat="server" Text="Address" ID="lblMailState" /></td></tr>
                <tr><td align="right"><b>Zip Code:</b></td><td>&nbsp;&nbsp;</td><td><asp:Label runat="server" Text="Address" ID="lblMailZip" /></td></tr>
            </table>
        </div>
    </div>
    
    <hr />
    
    <div><b>Your Property Information:</b></div>
    
    <div> 
        <table width="99%">
            <tr><td align="right"><b>Projected Assessed Value as of Jan 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /></b></td><td>&nbsp;&nbsp;</td><td><asp:Label runat="server" Text="" ID="lblAssessedValue2" /></td></tr>
            <tr>
                <td align="right"><b><font color="red">*</font>Your Opinion of Value as of Jan 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /></b></td><td>&nbsp;&nbsp;</td>
                <td>$<asp:TextBox ID="OpinionValue" runat="server" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" maxlength="10" Width="120px"/>&nbsp;
                    <asp:CustomValidator id="cvalOpinionValue" runat="server"  ErrorMessage="**" OnServerValidate="cvalOpinionValue_ServerValidate"> </asp:CustomValidator>
                    <asp:RegularExpressionValidator runat="server" id="valOpinionValue" ControlToValidate="OpinionValue" ErrorMessage="Invalid Amount"  
                        ValidationExpression="^[0-9\.,]*[0-9]|[\d]"  />
                        
                </td>
            </tr>
            <tr>
                <td align="right"><b>Property Type</b></td><td>&nbsp;&nbsp;</td>
                <td>&nbsp;&nbsp;<asp:DropDownList ID="ddlPropertyType" runat="server" AutoPostBack="True" >
                        <asp:ListItem Value="SFR">House/Condo/Townhome</asp:ListItem>
                        <asp:ListItem Value="R-I">Apartment/Multi-Units</asp:ListItem>
                        <asp:ListItem Value="C/I">Commercial/Industrial</asp:ListItem>
                        <asp:ListItem Value="VAC">Vacant Lot</asp:ListItem>
                        <asp:ListItem Value="OTH">Other</asp:ListItem>
                    </asp:DropDownList>
                </td>
            </tr>
        </table>
        <asp:panel runat="server" ID="sfrPanel" Visible="false">
            <table style="font-size:10px;" cellpadding="4">
                <tr class="TableHeader">
                    <td></td>
                    <td>Approx. Sq<br />Footage</td>
                    <td>Number of<br />Bedrooms</td>
                    <td>Number of<br />Bathrooms</td>
                </tr>
                <tr>
                    <td>Assessor records indicate the following characteristics<br />for your property</td>
                    <td style="font-weight:bold;"><asp:Label runat="server" Text="" ID="lblDBsqFoot" /></td>
                    <td style="font-weight:bold;"><asp:Label runat="server" Text="" ID="lblDBBedrooms" /></td>
                    <td style="font-weight:bold;"><asp:Label runat="server" Text="" ID="lblDBBathrooms" /></td>
                </tr>
                <tr>
                    <td>Please make any necessary corrections in the <br /> corresponding boxes.</td>
                    <td><asp:TextBox ID="sfrFootage" runat="server" maxLength="6" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/>
                        <asp:RegularExpressionValidator runat="server" id="valFootage" ControlToValidate="sfrFootage" ErrorMessage="**"  
                        ValidationExpression="^[0-9]+[0-9\,]*[0-9]" />
                        
                        

                    </td>
                    <td><asp:TextBox ID="sfrBedrooms" runat="server" maxLength="2" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/>
                        <asp:RegularExpressionValidator runat="server" id="valBedRoom" ControlToValidate="sfrBedrooms" ErrorMessage="**"  
                        ValidationExpression="[ ]*[+]?([0]*[1-9]{1,1}[0-9]{0,9})[ ]*" />
                    </td>
                    <td><asp:TextBox ID="sfrBathrooms" runat="server" maxLength="2" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/>
                        <asp:RegularExpressionValidator runat="server" id="valBath" ControlToValidate="sfrBathrooms" ErrorMessage="**"  
                        ValidationExpression="[ ]*[+]?([0]*[1-9]{1,1}[0-9]{0,9})[ ]*" />
                    </td>
                </tr>
                
            </table>
        </asp:panel>
        <asp:panel runat="server" ID="riPanel" Visible="false">
            <table style="font-size:10px;" cellpadding="2">
                <tr>
                   <td rowspan="3" class="TableHeader">Please provide the following information for your property</td>
                </tr>
                <tr class="TableHeader">
                    <td></td>
                    <td>Approx. Sq<br />Footage</td>
                    <td>Number of<br />Bedrooms</td>
                    <td>Number of<br />Bathrooms</td>
                    <td>Number of<br />Units</td>
                </tr>
                <tr class="TableHeader">
                    <td></td>
                    
                    <td><asp:TextBox ID="riFootage" runat="server" maxlength="9" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/>
                        <asp:RegularExpressionValidator runat="server" id="valriFootage" ControlToValidate="riFootage" ErrorMessage="**"  
                        ValidationExpression="^[0-9]+[0-9\,]*[0-9]" />
                    </td>
                    <td><asp:TextBox ID="riBedrooms" runat="server" maxlength="4" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/>
                        <asp:RegularExpressionValidator runat="server" id="valriBedrooms" ControlToValidate="riBedrooms" ErrorMessage="**"  
                        ValidationExpression="[ ]*[+]?([0]*[1-9]{1,1}[0-9]{0,9})[ ]*" />
                    </td>
                    <td><asp:TextBox ID="riBathrooms" runat="server" maxlength="4" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/>
                        <asp:RegularExpressionValidator runat="server" id="valriBathrooms" ControlToValidate="riBathrooms" ErrorMessage="**"  
                        ValidationExpression="[ ]*[+]?([0]*[1-9]{1,1}[0-9]{0,9})[ ]*" />
                    </td>
                    <td><asp:TextBox ID="riUnits" runat="server" maxlength="4" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/>
                        <asp:RegularExpressionValidator runat="server" id="valriUnits" ControlToValidate="riUnits" ErrorMessage="**"  
                        ValidationExpression="[ ]*[+]?([0]*[1-9]{1,1}[0-9]{0,9})[ ]*" />
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table cellpadding="2" style="font-size:10px;">
                            <tr>
                                <td>
                                    Provide income information (ANNUALIZED): 1) <b>estimated gross income</b>, 2) <b>vacancy and collection losses</b>, 3) 
                                    <b>expenses</b>, and 4) <b>Other sources of income</b> (billboards, cell towers, parking spaces, etc.).  Also indicate if income is full 
                                    service gross, triple net, etc., and if taxes are included in the expenses.
                                </td>
                                <td>
                                    <asp:TextBox ID="riIncomeInfo" runat="server" BorderColor="DarkGray" TextMode="MultiLine" 
                                        BorderStyle="Solid" BorderWidth="1px" Width="250px" Height="70" onkeyup="return MaxLimit(this,1000)"  onpaste="return MaxLimit(this,1000)" />    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </asp:panel>
        <asp:panel runat="server" ID="ciPanel" Visible="false">
            <table style="font-size:10px;" cellpadding="2">
                <tr>
                   <td rowspan="3" class="TableHeader">Please provide the following information for your property</td>
                </tr>
                <tr class="TableHeader">
                    <td></td>
                    <td>Approx. Sq<br />Footage</td>
                    <td>Number of<br />Units</td>
                </tr>
                <tr class="TableHeader">
                    <td></td>
                    <td><asp:TextBox ID="ciFootage" runat="server" maxlength="9" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/>
                        <asp:RegularExpressionValidator runat="server" id="valciFootage" ControlToValidate="ciFootage" ErrorMessage="**"  
                        ValidationExpression="^[0-9]+[0-9\,]*[0-9]" />
                    </td>
                    <td><asp:TextBox ID="ciUnits" runat="server" maxlength="4" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/>
                        <asp:RegularExpressionValidator runat="server" id="valciUnits" ControlToValidate="ciUnits" ErrorMessage="**"  
                        ValidationExpression="[ ]*[+]?([0]*[1-9]{1,1}[0-9]{0,9})[ ]*" />
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table cellpadding="2" style="font-size:10px;">
                            <tr>
                                <td>
                                    Provide income information (ANNUALIZED): 1) <b>estimated gross income</b>, 2) <b>vacancy and collection losses</b>, 3) 
                                    <b>expenses</b>, and 4) <b>Other sources of income</b> (billboards, cell towers, parking spaces, etc.).  Also indicate 
                                    if income is full service gross, triple net, etc., and if taxes are included in the expenses.
                                </td>
                                <td>
                                    <asp:TextBox ID="ciIncomeInfo" runat="server" BorderColor="DarkGray" TextMode="MultiLine" 
                                        BorderStyle="Solid" BorderWidth="1px" Width="250px" Height="70" onkeyup="return MaxLimit(this,1000)"  onpaste="return MaxLimit(this,1000)"/>    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </asp:panel>
        <asp:panel runat="server" ID="vacPanel" Visible="false">
            <table cellpadding="2" style="font-size:10px; font-weight:bold;">
                <tr>
                    <td>
                        Please provide the following information for your property: approximate square footage, street location and nearest cross street, and city.
                        <br /><br />
                        Also indicate if the property is undeveloped, land-locked, impacted by an easement, has a view, what portions are usable, etc.
                    </td>
                    <td>
                        <asp:TextBox ID="vacInfo" runat="server" BorderColor="DarkGray" TextMode="MultiLine" 
                            BorderStyle="Solid" BorderWidth="1px" Width="250px" Height="90" onkeyup="return MaxLimit(this,1000)"  onpaste="return MaxLimit(this,1000)" />    
                    </td>
                </tr>
            </table>
        </asp:panel>
        <asp:panel runat="server" ID="otPanel" Visible="false">
            <table cellpadding="2" style="font-size:10px;">
                <tr>
                    <td>
                        <b>Please provide as much information you can about your property and the comparable sales.  Include major and minor uses of the 
                        property, how many units if applicable, any special conditions, etc.</b>
                        <br /><br />
                        Provide all available income information (ANNUALIZED): 1) <b>estimated gross income</b>, 2) <b>vacancy and collection losses</b>, 3) 
                        <b>expenses</b>, and 4) <b>Other sources of income</b> (billboards, cell towers, parking spaces, etc.).  Also indicate if income is full 
                        service gross, triple net, etc., and if taxes are included in the expenses.
                    </td>
                    <td>
                        <asp:TextBox ID="otInfo" runat="server" BorderColor="DarkGray" TextMode="MultiLine" 
                            BorderStyle="Solid" BorderWidth="1px" Width="250px" Height="120" onkeyup="return MaxLimit(this,1000)"  onpaste="return MaxLimit(this,1000)" />    
                    </td>
                </tr>
            </table>
        </asp:panel>
        
    
    
    <hr />

    <div><b>Comparable Sales:</b><font style="text-align:right;font-size: 8.5pt;font-family: Verdana, Arial;">&nbsp;(Optional)</font></div>
        <div style="font-size:9px; padding: 5 0 5 0">
            The best information you can provide that supports your opinion of the market value of your property is sales of comparable properties. You should try to find 
            two comparable sales that sold as close to January 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> as possible, but no later than March 31, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" />. While the submission of sales 
            is helpful in determining the market value of your property, applications submitted without comparable sales will be accepted and processed.
    </div>
        <fieldset>
        <legend>Comparable 1:</legend>
        <table style="font-weight:bold; font-size:12px" border=0>
            <tr>
                <td>
                    <table style="font-weight:bold; font-size:10px">
                        <tr>
                            <td>Address: 
                                    <asp:RegularExpressionValidator runat="server" id="valCompSale1Address" ControlToValidate="CompSale1Address" ErrorMessage=" **"  
                                    ValidationExpression="^[A-Za-z0-9\.\;\:\#\!\@\&\,\?\~/'-_\s]{0,150}$" /></td>
                            <td>City:
                                    <asp:RegularExpressionValidator runat="server" id="valCompSale1City" ControlToValidate="CompSale1City" ErrorMessage=" **"  
                                    ValidationExpression="^[A-Za-z\s]*" /></td>
                            <td>Zip:
                                    <asp:RegularExpressionValidator runat="server" id="valCompSale1Zip" ControlToValidate="CompSale1Zip" ErrorMessage=" **"  
                                    ValidationExpression="[ ]*[+]?([0]*[1-9]{1,1}[0-9]{0,9})[ ]*" /></td>

                            <td rowspan=2 style="font-size:15px;">&nbsp;&nbsp;OR&nbsp;&nbsp;</td>
                            <td>Assessor No. :</td>
                        </tr>
                        <tr>
                            <td><asp:TextBox ID="CompSale1Address" runat="server" maxlength="32" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="210px" />
                                
                            </td>
                            <td><asp:TextBox ID="CompSale1City" runat="server" maxlength="24" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="100px" /></td>
                            <td><asp:TextBox ID="CompSale1Zip" runat="server" maxlength="5" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px" /></td>
                            <td><asp:TextBox ID="CompSale1AIN" runat="server" maxlength="15" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="120px" />
                                <asp:RegularExpressionValidator runat="server" id="valCompSale1AIN" ControlToValidate="CompSale1AIN" ErrorMessage="Invalid AIN"  
                                    ValidationExpression="^(\d{10})|(\d{4}[-|\s]\d{3}[-|\s]\d{3}\s{0,3})$" SetFocusOnError="True" />
                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan=4>
                    <table style="font-weight:bold; font-size:10px">
                        <tr>
                            <td>Sale Date
                            <br /><font style="font-weight:bold; font-size:8px;">(No later than 03/31/<asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" />)</font>
                                
                            </td>
                            <td align="right">
                                <asp:TextBox ID="CompSale1Date" runat="server" BorderColor="DarkGray" BorderStyle="Solid" maxlength ="25" BorderWidth="1px" Width="80px"/>
                            </td>
                            <td>&nbsp</td>
                            <td rowspan="2" >Property Description <span style="font-weight:normal; font-size:9px"></span><br />
                            <asp:TextBox id="CompSale1Desc" runat="server" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" TextMode="MultiLine" Width="300px" onkeyup="return MaxLimit(this,1000)"  onpaste="return MaxLimit(this,1000)"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Sale Price<font style="font-weight:normal; font-size:8px;"></font>
                                <asp:RegularExpressionValidator runat="server" id="valCompSale1Price" ControlToValidate="CompSale1Price" ErrorMessage="**"  
                                     ValidationExpression="^[0-9][\w\.,]*[0-9]|[\d]" SetFocusOnError="True" />
                            </td>
                            <td align="right">$<asp:TextBox ID="CompSale1Price" runat="server" MaxLength="9" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="80px"/></td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                       
                    </table>
                </td>
            </tr>
        </table>
        </fieldset>
        
        <fieldset>
        <legend>Comparable 2:</legend>
        <table style="font-weight:bold; font-size:12px" border=0>
            <tr>
                <td>
                    <table style="font-weight:bold; font-size:10px">
                        <tr>
                            <td>Address: 
                                    <asp:RegularExpressionValidator runat="server" id="valCompSale2Address" ControlToValidate="CompSale2Address" ErrorMessage=" **"  
                                        ValidationExpression="^[A-Za-z0-9\.\;\:\#\!\@\&\,\?\~/'-_\s]{0,150}$" SetFocusOnError="True" /></td>
                            <td>City:
                                    <asp:RegularExpressionValidator runat="server" id="valCompSale2City" ControlToValidate="CompSale2City" ErrorMessage=" **"  
                                        ValidationExpression="^[A-Za-z\s]*" /></td>
                            <td>Zip:
                                    <asp:RegularExpressionValidator runat="server" id="valCompSale2Zip" ControlToValidate="CompSale2Zip" ErrorMessage=" **"  
                                         ValidationExpression="[ ]*[+]?([0]*[1-9]{1,1}[0-9]{0,9})[ ]*" /></td>

                            <td rowspan=2 style="font-size:15px;">&nbsp;&nbsp;OR&nbsp;&nbsp;</td>
                            <td>Assessor No. :</td>
                        </tr>
                        <tr>
                            <td><asp:TextBox ID="CompSale2Address" runat="server"  maxlength="32" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="210px"/></td>
                            <td><asp:TextBox ID="CompSale2City" runat="server"  maxlength="24" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="100px"/></td>
                            <td><asp:TextBox ID="CompSale2Zip" runat="server"  maxlength="5" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="60px"/></td>
                            <td><asp:TextBox ID="CompSale2AIN" runat="server"  maxlength="15" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="120px"/>
                                <asp:RegularExpressionValidator runat="server" id="valCompSale2AIN" ControlToValidate="CompSale2AIN" ErrorMessage="Invalid AIN"  
                                     ValidationExpression="^(\d{10})|(\d{4}[-|\s]\d{3}[-|\s]\d{3}\s{0,3})$" SetFocusOnError="True" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan=4>
                    <table style="font-weight:bold; font-size:10px">
                        <tr>
                            <td>Sale Date
                                <br /><font style="font-weight:bold; font-size:8px;">(No later than 03/31/<asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" />)</font></td>
                            <td align="right"><asp:TextBox ID="CompSale2Date" maxlength="25" runat="server" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="80px"/></td>
                            <td>&nbsp;</td>
                            <td rowspan="2" >Property Description<br />
                            <asp:TextBox ID="CompSale2Desc" runat="server" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" TextMode="MultiLine" Width="300px"  onkeyup="return MaxLimit(this,1000)"  onpaste="return MaxLimit(this,1000)" />
                            </td>
                        </tr>
                        <tr>
                            <td>Sale Price<font style="font-weight:normal; font-size:8px;"></font>
                                <asp:RegularExpressionValidator runat="server" id="valCompSale2rice" ControlToValidate="CompSale2Price" ErrorMessage="**"  
                                     ValidationExpression="^[0-9][\w\.,]*[0-9]|[\d]" />
                            </td>
                            <td align="right">$<asp:TextBox ID="CompSale2Price" runat="server" MaxLength="9" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" Width="80px"/></td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </fieldset>            
        
        <div style="font-size:9px; padding: 5 0 5 0">
            *Single Family/Multi-Res: Include building size, year built, # of bedrooms & baths, proximity, # of units and income 
            (if Multi-Res). Commercial/Industrial: Include income, building and land size, use, zoning, year built, and proximity.
        </div>
    </div>
    
    <hr />
    
    <div><b>Additional Information:</b></div>
    <div style="font-size:10px; padding: 5 0 5 0">
        Please provide any additional information you would like us to consider in valuing your property. If your property consists of 
        more than one parcel, list the other associated parcel numbers here.
        <br /><br />
        <asp:TextBox ID="AdditionalInfo" runat="server" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" TextMode="MultiLine" Width="600px" onkeyup="return MaxLimit(this,1000)"  onpaste="return MaxLimit(this,1000)" />
        &nbsp;<br /><br />
        <asp:CustomValidator id="CustomValidator1" runat="server" ErrorMessage="Must check" OnServerValidate="CustomValidator1_ServerValidate"> </asp:CustomValidator>
        <font color="red">*</font> &nbsp;<asp:Checkbox ID="ConfirmInfo" runat="server" />I confirm that I am the owner of this property and the above information is true. 
        <br /><br />
        <div style="font-size:12px;color:Red;font-weight:bold; text-align:center;">
            <asp:label id="lblError" visible = "false" runat="server" text="<i>You must provide all required fields (Owner Name and your Opinion of Value) and<br>confirm that you are the owner before proceeding. <br><br> * Required fields</i>"></asp:label>
        </div>
        <br />
        <div align="center">
            <asp:Button ID="BtnCancel" runat="server" Text="CANCEL" CssClass="ButtonStandard" />&nbsp;&nbsp;
            <asp:Button ID="BtnNext" runat="server" Text="NEXT" CssClass="ButtonStandard" />
        </div>
    </div>
</div>