<<VOIP CONFIG FILE>>Version:2.0002

<GLOBAL CONFIG MODULE>
Static IP          :<?php echo $ip."\n"?>
Static NetMask     :255.255.0.0
Static GateWay     :192.168.255.254
Default Protocol   :2
Primary DNS        :192.168.255.254
Alter DNS          :192.168.255.254
DHCP Mode          :1
DHCP Dns           :1
Domain Name        :
Host Name          :phone<?php $sip1PhoneNumber . "\n"?>
Pppoe Mode         :0
HTL Start Port     :10000
HTL Port Number    :200
SNTP Server        :192.168.255.254
Enable SNTP        :1
Time Zone          :27
Enable Daylight    :0
SNTP Time Out      :3600
DayLight Shift Min :60
DayLight Start Mon :3
DayLight Start Week:5
DayLight Start Wday:0
DayLight Start Hour:2
DayLight Start Min :0
DayLight End Mon   :10
DayLight End Week  :5
DayLight End Wday  :0
DayLight End Hour  :2
DayLight End Min   :0
MMI Set            :3

<LAN CONFIG MODULE>
Lan Ip             :192.169.10.1
Lan NetMask        :255.255.0.0
Bridge Mode        :0

<TELE CONFIG MODULE>
Dial End With #    :1
Dial Fixed Length  :0
Fixed Length       :11
Dial With Timeout  :1
Dial Timeout value :5
Poll Sequence      :0
Accept Any Call    :1
Phone Prefix       :
Local Area Code    :
IP call network    :.
--Port Config--    :
P1 No Disturb      :0
P1 No Dial Out     :0
P1 No Empty Calling:0
P1 Enable CallerId :1
P1 Forward Service :0
P1 SIP TransNum    :
P1 SIP TransAddr   :
P1 SIP TransPort   :5060
P1 CallWaiting     :1
P1 CallTransfer    :1
P1 Call3Way        :1
P1 AutoAnswer      :0
P1 No Answer Time  :20
P1 Extention No.   :
P1 Hotline Num     :
P1 Record Server   :
P1 Enable Record   :0
P1 Busy N/A Line   :0

<DSP CONFIG MODULE>
Signal Standard    :2
Handdown Time      :200
G729 Payload Length:1
G722 Timestamps    :0
VAD                :0
Ring Type          :1
Dtmf Payload Type  :101
Disable Handfree   :0
--Port Config--    :
P1 Output Vol      :5
P1 Input Vol       :5
P1 HandFree Vol    :5
P1 RingTone Vol    :5
P1 Codec           :0
P1 Voice Record    :0
P1 Record Playing  :1
P1 UserDef Voice   :0

<SIP CONFIG MODULE>
SIP  Port          :5060
Stun Address       :
Stun Port          :3478
Stun Effect Time   :50
SIP  Differv       :0
DTMF Mode          :1
Extern Address     :
Url Convert        :1
Quote Name         :0
Reg Retry Time     :30
Dtmf Info Convert  :1
--SIP Line List--  :
SIP1 Phone Number  :<?php echo $sip1PhoneNumber."\n"?>
SIP1 Sip Name      :hekphone
SIP1 Display Name  :<?php echo $sf_data->getRaw('sip1DisplayName'). "\n"?>
SIP1 Register Addr :192.168.255.254
SIP1 Register Port :5060
SIP1 Register User :<?php echo $sip1User."\n"?>
SIP1 Register Pwd  :<?php echo $sip1Pwd . "\n"?>
SIP1 Register TTL  :300
SIP1 Enable Reg    :1
SIP1 Proxy Addr    :192.168.255.254
SIP1 Proxy Port    :5060
SIP1 Proxy User    :<?php echo $sip1User . "\n"?>
SIP1 Proxy Pwd     :<?php echo $sip1Pwd . "\n"?>
SIP1 Signal Enc    :0
SIP1 Signal Key    :
SIP1 Media Enc     :0
SIP1 Media Key     :
SIP1 Local Domain  :
SIP1 Fwd Service   :0
SIP1 Fwd Number    :
SIP1 Enable Detect :0
SIP1 Detect TTL    :60
SIP1 Server Type   :0
SIP1 User Agent    :tiptel 83voip
SIP1 PRACK         :0
SIP1 KEEP AUTH     :0
SIP1 Session Timer :0
SIP1 DTMF Mode     :0
SIP1 Use Stun      :0
SIP1 Via Port      :1
SIP1 Subscribe     :0
SIP1 Sub Expire    :300
SIP1 Single Codec  :0
SIP1 CLIR          :0
SIP1 Direct Contact:0
SIP1 DNS SRV       :0
SIP1 Ban Anonymous :0
SIP1 Dial Without R:0
SIP1 Strict Proxy  :0
SIP1 RFC Ver       :1
SIP1 Use Mixer     :0
SIP1 Mixer Uri     :
SIP2 Phone Number  :
SIP2 Sip Name      :
SIP2 Display Name  :
SIP2 Register Addr :
SIP2 Register Port :5060
SIP2 Register User :
SIP2 Register Pwd  :
SIP2 Register TTL  :60
SIP2 Enable Reg    :0
SIP2 Proxy Addr    :
SIP2 Proxy Port    :5060
SIP2 Proxy User    :
SIP2 Proxy Pwd     :
SIP2 Signal Enc    :0
SIP2 Signal Key    :
SIP2 Media Enc     :0
SIP2 Media Key     :
SIP2 Local Domain  :
SIP2 Fwd Service   :0
SIP2 Fwd Number    :
SIP2 Enable Detect :0
SIP2 Detect TTL    :60
SIP2 Server Type   :0
SIP2 User Agent    :Voip Phone 1.0
SIP2 PRACK         :0
SIP2 KEEP AUTH     :0
SIP2 Session Timer :0
SIP2 DTMF Mode     :0
SIP2 Use Stun      :0
SIP2 Via Port      :1
SIP2 Subscribe     :0
SIP2 Sub Expire    :300
SIP2 Single Codec  :0
SIP2 CLIR          :0
SIP2 Direct Contact:0
SIP2 DNS SRV       :0
SIP2 Ban Anonymous :0
SIP2 Dial Without R:0
SIP2 Strict Proxy  :0
SIP2 RFC Ver       :1
SIP2 Use Mixer     :0
SIP2 Mixer Uri     :
SIP3 Phone Number  :
SIP3 Sip Name      :
SIP3 Display Name  :
SIP3 Register Addr :
SIP3 Register Port :5060
SIP3 Register User :
SIP3 Register Pwd  :
SIP3 Register TTL  :60
SIP3 Enable Reg    :0
SIP3 Proxy Addr    :
SIP3 Proxy Port    :5060
SIP3 Proxy User    :
SIP3 Proxy Pwd     :
SIP3 Signal Enc    :0
SIP3 Signal Key    :
SIP3 Media Enc     :0
SIP3 Media Key     :
SIP3 Local Domain  :
SIP3 Fwd Service   :0
SIP3 Fwd Number    :
SIP3 Enable Detect :0
SIP3 Detect TTL    :60
SIP3 Server Type   :0
SIP3 User Agent    :Voip Phone 1.0
SIP3 PRACK         :0
SIP3 KEEP AUTH     :0
SIP3 Session Timer :0
SIP3 DTMF Mode     :0
SIP3 Use Stun      :0
SIP3 Via Port      :1
SIP3 Subscribe     :0
SIP3 Sub Expire    :300
SIP3 Single Codec  :0
SIP3 CLIR          :0
SIP3 Direct Contact:0
SIP3 DNS SRV       :0
SIP3 Ban Anonymous :0
SIP3 Dial Without R:0
SIP3 Strict Proxy  :0
SIP3 RFC Ver       :1
SIP3 Use Mixer     :0
SIP3 Mixer Uri     :
SIP4 Phone Number  :
SIP4 Sip Name      :
SIP4 Display Name  :
SIP4 Register Addr :
SIP4 Register Port :5060
SIP4 Register User :
SIP4 Register Pwd  :
SIP4 Register TTL  :60
SIP4 Enable Reg    :0
SIP4 Proxy Addr    :
SIP4 Proxy Port    :5060
SIP4 Proxy User    :
SIP4 Proxy Pwd     :
SIP4 Signal Enc    :0
SIP4 Signal Key    :
SIP4 Media Enc     :0
SIP4 Media Key     :
SIP4 Local Domain  :
SIP4 Fwd Service   :0
SIP4 Fwd Number    :
SIP4 Enable Detect :0
SIP4 Detect TTL    :60
SIP4 Server Type   :0
SIP4 User Agent    :Voip Phone 1.0
SIP4 PRACK         :0
SIP4 KEEP AUTH     :0
SIP4 Session Timer :0
SIP4 DTMF Mode     :0
SIP4 Use Stun      :0
SIP4 Via Port      :1
SIP4 Subscribe     :0
SIP4 Sub Expire    :300
SIP4 Single Codec  :0
SIP4 CLIR          :0
SIP4 Direct Contact:0
SIP4 DNS SRV       :0
SIP4 Ban Anonymous :0
SIP4 Dial Without R:0
SIP4 Strict Proxy  :0
SIP4 RFC Ver       :1
SIP4 Use Mixer     :0
SIP4 Mixer Uri     :
SIP5 Phone Number  :
SIP5 Sip Name      :
SIP5 Display Name  :
SIP5 Register Addr :
SIP5 Register Port :5060
SIP5 Register User :
SIP5 Register Pwd  :
SIP5 Register TTL  :60
SIP5 Enable Reg    :0
SIP5 Proxy Addr    :
SIP5 Proxy Port    :5060
SIP5 Proxy User    :
SIP5 Proxy Pwd     :
SIP5 Signal Enc    :0
SIP5 Signal Key    :
SIP5 Media Enc     :0
SIP5 Media Key     :
SIP5 Local Domain  :
SIP5 Fwd Service   :0
SIP5 Fwd Number    :
SIP5 Enable Detect :0
SIP5 Detect TTL    :60
SIP5 Server Type   :0
SIP5 User Agent    :Voip Phone 1.0
SIP5 PRACK         :0
SIP5 KEEP AUTH     :0
SIP5 Session Timer :0
SIP5 DTMF Mode     :0
SIP5 Use Stun      :0
SIP5 Via Port      :1
SIP5 Subscribe     :0
SIP5 Sub Expire    :300
SIP5 Single Codec  :0
SIP5 CLIR          :0
SIP5 Direct Contact:0
SIP5 DNS SRV       :0
SIP5 Ban Anonymous :0
SIP5 Dial Without R:0
SIP5 Strict Proxy  :0
SIP5 RFC Ver       :1
SIP5 Use Mixer     :0
SIP5 Mixer Uri     :

<PPPoE CONFIG MODULE>
Pppoe User         :user123
Pppoe Password     :password
Pppoe Service      :ANY
Pppoe Ip Address   :

<MMI CONFIG MODULE>
Telnet Port        :23
Web Port           :80
Remote Control     :1
Enable MMI Filter  :0
Telnet Prompt      :
--MMI Account--    :
Account1 Name      :admin
Account1 Pass      :<?php  echo $fronendpwd . "\n"?>
Account1 Level     :10
Account2 Name      :guest
Account2 Pass      :<?php  echo $fronendpwd . "\n"?>
Account2 Level     :5

<QOS CONFIG MODULE>
Enable VLAN        :0
Enable diffServ    :0
Enable SIP diffServ:1
DiffServ Value     :184
SIP DiffServ Value :184
Save VALN Mac      :1
VLAN ID            :256
802.1P Value       :0
VLAN Recv Check    :1
Data VLAN ID       :254
Data 802.1P Value  :0
Diff Data Voice    :0

<DEBUG CONFIG MODULE>
MGR Trace Level    :0
SIP Trace Level    :0
Trace File Info    :0

<AAA CONFIG MODULE>
Enable Syslog      :0
Syslog address     :0.0.0.0
Syslog port        :514

<ACCESS CONFIG MODULE>
Enable In Access   :0
Enable Out Access  :0

<DHCP CONFIG MODULE>
Enable DHCP Server :1
Enable DNS Relay   :1
DHCP Update Flag   :0
TFTP  Server       :0.0.0.0
--DHCP List--      :
Item1 name         :lan
Item1 Start Ip     :192.169.10.1
Item1 End Ip       :192.169.10.30
Item1 Param        :snmk=255.255.0.0:maxl=1440:rout=192.169.10.1:dnsv=192.169.10.1

<NAT CONFIG MODULE>
Enable Nat         :1
Enable Ftp ALG     :1
Enable H323 ALG    :0
Enable PPTP ALG    :1
Enable IPSec ALG   :1

<PHONE CONFIG MODULE>
Keypad Password    :811
LCD Logo           :HEKphone
SIP1 Server Name   :hekphone
SIP2 Server Name   :Name2
SIP3 Server Name   :Name3
SIP4 Server Name   :Name4
SIP5 Server Name   :Name5
LCD Constrast      :5
LCD Luminance      :1
FuncKey Type       :3
<?php if ($overridePersonalSettings):?>
Memory Key 1       :
Memory Key 2       :
Memory Key 3       :
Memory Key 4       :
Memory Key 5       :
Memory Key 6       :
Memory Key 7       :
Memory Key 8       :
Memory Key 9       :
Memory Key 10      :
<?php endif;?>

<AUTOUPDATE CONFIG MODULE>
Download Username  :user
Download password  :pass
Download Server IP :0.0.0.0
Config File Name   :
Config File Key    :
Download Protocol  :1
Download Mode      :0
Download Interval  :1

<VPN CONFIG MODULE>
VPN mode           :0
L2TP LNS IP        :
L2TP User Name     :
L2TP Password      :
Enable VPN Tunnel  :0
VPN Server IP      :0.0.0.0
VPN Server Port    :80
Server Group ID    :VPN
Server Area Code   :12345
<<END OF FILE>>
