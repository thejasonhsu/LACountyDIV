<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="divhome.aspx.vb" Inherits="extranet.home" %>

<%@ Register Assembly="Lanap.BotDetect" Namespace="Lanap.BotDetect" TagPrefix="BotDetect" %>

<div style="text-align: center">
<h1>Decline-in-Value Request for Review</h1>

<h2>Online Filing</h2>
</div>

<!--
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td colspan="2" style="font-weight: bold; font-size: 12px; color: black; font-family: Verdana;">IMPORTANT: The filing period for a 2012 Decline-in-Value request for review has expired.</td>
    </tr>
    <tr>
        <td width="92">&nbsp;</td>
        <td class="DivLeftAlign">Requests for a 2013 Decline-in-Value Review will be accepted between July 2 and November 30, 2013.</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td>&nbsp;</td>
        <td class="DivLeftAlign">Online applications cannot currently be filed by tax agents.</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td>&nbsp;</td>
        <td class="DivLeftAlign">To check the status of your decline-in-value, <a href="/extranet/guides/prop8status.aspx">click here</a>.</td>
    </tr>
</table>     
-->


<div class="DivLeftAlign">
    <font style="font-weight: bold; font-size: 12px; color: black; font-family: Verdana;">IMPORTANT:</font> 
    Applications MUST be filed between <font style="color: red;">July 2 and December 1, <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /></font>.<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Online applications cannot currently be filed by tax agents.
</div>
<br />
<div class="DivPinInstruction">
    Please enter the 10-digit Assessor's Identification Number (AIN) and the Property Identification Number (PIN) that appears 
    on your Annual Property Tax Bill, then click on &quot;Login&quot;.
</div>

<div class="DivFrame">
    <div style="white-space:nowrap; padding:15px 0px 15px 0px; height:180px;">
        <div>
                <span id="Span1" style="font-size:11px; font-weight:bold;color:Red ">
                        <asp:Label id="lblErrorAINPIN" runat="server" text="" ></asp:Label>
                </span>
                <div style="float:left;">
                    <label id="errMsg" visible="false" runat="server"></label><br />
                    AIN: <asp:TextBox id="AIN" runat="server"  BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" MaxLength="20" Value="" Width="150"></asp:TextBox>
                    
                    <asp:requiredfieldvalidator id="rqvalAIN" runat="server" ErrorMessage="AIN Required" Display="dynamic"
					ControlToValidate="AIN"></asp:requiredfieldvalidator>
                    <br />
                    PIN: <asp:TextBox id="PIN" runat="server" TextMode="password" BorderColor="DarkGray" BorderStyle="Solid" BorderWidth="1px" MaxLength="25" Value="" Width="150"></asp:TextBox>
                    
                    <asp:requiredfieldvalidator id="rqvalPIN" runat="server" ErrorMessage="PIN Required" Display="dynamic"
					ControlToValidate="PIN"></asp:requiredfieldvalidator>
                    &nbsp;&nbsp;&nbsp;     
                    
                </div>

                <div style="float:right; font-size:10px; padding: 15px 10px 5px 2px;">               
                    <a href="javascript:newwindow=window.open('http://lacountypropertytax.com/portal/bills/annualbill.aspx','Bill');if (window.focus) {newwindow.focus();}">Where do I find my AIN and PIN? <br />(See items #2 and #6 on the sample form.)</a>
                </div>
                <div id="PromptDiv">
                    <span id="Prompt">Type the characters you see in the picture</span>
                </div>
                <table>
                <tr>
                    <td><BotDetect:Captcha id="SampleCaptcha" runat="server"  SoundIconAltText="click to hear"   /></td>
                    <td>
                            <table>
                                <tr>
                                    <td style="vertical-align :top;font-size:10px; font-weight:bold;color:black; " >Hear the code</td>
                                </tr>
                                <tr>
                                <td style="vertical-align :top;font-size:5px; font-weight:bold;color:black;" >&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="font-size:10px; font-weight:bold;color:black;">Change the code</td>
                                </tr>
                            </table>
                    </td>
                </tr>
                <tr>
                    <td colspan ="2"> 
                        <asp:TextBox id="CodeTextBox" runat="server"></asp:TextBox>
                        <asp:Button id="goBtn" runat="server" text="Login"  />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span id="Span2" style="font-size:11px; font-weight:bold;color:Red ">
                            <asp:Label id="MessageIncorrectLabel" runat="server" visible="false" ></asp:Label>
                        </span>
                    </td>
                </tr>
                </table>
                <div style="float:left;padding:15px 0px 15px 0px;">
                By entering the information above, you can:
                <ul>
                    <li>View your <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> assessed value or the results of any <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> <br />decline-in-value review</li>
                    <li>File a <asp:Label EnableViewState="false" runat="server" Text="<%$ Resources:divolf, FilingYear %>" /> Decline-in-Value Review Application online</li>
                    <li>Review an existing application</li>
                    <li>You will be able to review and print the information you provide <br />at the conclusion of this session</li>
                </ul>      
                </div>
            
        </div>
              
    </div>
</div>
<br />
