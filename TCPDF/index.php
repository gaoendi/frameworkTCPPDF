<?php
/**
 * 官网文档地址:https://tcpdf.org/
 * Github地址:https://github.com/tecnickcom/tcpdf
 * Created by PhpStorm.
 * User: Jason
 * Date: 2019/1/23
 * Time: 13:23
 */

// 导入类库
require_once './vendor/autoload.php';

// TCPDF类库存在Bug:重新定义TCPDF中的K_PATH_IMAGES常量(解决:设置头部logo不显示的问题，如果不定义常量，可以将logo图片移动到vendor/tecnickcom/examples/images下)
define('K_PATH_IMAGES', 'D:\newPhpStudy\WWW\TCPDF\images\\');
// 解决中文乱码问题:
// 1.下载Droid Sans字体:本次项目中已包含，未包含网盘下载地址：http://pan.baidu.com/s/1bnq21Ld
// 2.将解压后的三个文件:droidsansfallback.php、droidsansfallback.z和droidsansfallback.ctg.z 放入 vendor/tecnickcom/tcpdf/fonts/目录下
// 3.修改类库常量(vendor/tecnickcom/tcpdf/config/tcpdf_config.php):define ('PDF_FONT_NAME_DATA', 'droidsansfallback'); define ('PDF_FONT_NAME_MAIN', 'droidsansfallback');
// 4.不修改第三步的前提下，在调用setHeaderFont方法时可自行定义

// 创建新的PDF文档
// 说明:
// P1:页面方向[P,L]
// P2:文档计量单位[pt = point, mm = millimeter, cm = centimeter, in = inch]
// P3:页面格式[A4]
// P4:输入文本是否为Unicode[true, false]
// P5:字符集编码[UTF-8....],仅在转换回HTML实体时使用
// P6:不推荐使用的功能[false]
// P7:是否PDF/A模式[true, false]
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// 设置文档信息[定义文档的创建者,这通常是生成PDF的应用程序的名称]
$pdf->SetCreator('ZhouCreator_' . date('Ymd'));
// 定义文档的作者
$pdf->SetAuthor('Jason');
// 定义文档的标题
$pdf->SetTitle('PDF测试标题');
// 定义文档的主题
$pdf->SetSubject('PDF测试主题');
// 设置文档的关键字,格式:A1 A2 A3
$pdf->SetKeywords('关键字1,关键字2,关键字3');
// 设置默认头信息
// 说明:
// P1:图标Logo地址,必须是常量K_PATH_IMAGES下的文件
// P2:图标Logo宽度
// P3:作为标题打印在文档标题上的字符串
// P4:要在文档头上打印的字符串
// P5:文本的RGB数组颜色[0,0,0]
// P6:线条的RGB数组颜色[0,0,0]
$pdf->SetHeaderData('logo.jpg', 15, '周小店', 'www.smallzhou.cn', [50, 35, 125], [200, 80, 128]);
// 设置页眉和页脚字体（描述基本字体参数,数组格式[字体，样式，大小]）
$pdf->setHeaderFont(['droidsansfallback', '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont(['droidsansfallback', '', PDF_FONT_SIZE_DATA]);
// 设置默认单空格字体
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// 设定页边空白(下边的三个统称)
// 定义左、上、右、边距
// 说明:
// P1:左边距 P2:上边距 P3:右边距（设置为-1，以左边距为准） P4:True/False,true的情况下覆盖默认页边框
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// 设置页眉边距(以用户单位表示的距离):页眉和上页边距之间的最小距离
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// 设置页脚边距(以用户单位表示的距离):页脚和底页边距之间的最小距离
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// 启用或禁用自动分页符模式(启用时，第二个参数是与定义触发限制的页面底部的距离。默认情况下，模式为“开”，边距为2 cm。)
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// 设置调整因子以将像素转换为用户单位
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// 设置用于打印字符串的字体
// 说明:
// P1:字体 P2:样式 P3:大小
$pdf->SetFont('droidsansfallback', '', 10);


// 向文档添加新页
// 说明:
// P1:页面方向 P2:页面的格式 P3:如果为真，则用当前页边距覆盖默认页边距 P4:如果未真，添加的页面将用于显示目录
$pdf->AddPage();
// 定义html代码
$html = '<h1>HTML 示例</h1>
特殊字符: &lt; € &euro; &#8364; &amp; è &egrave; &copy; &gt; \\slash \\\\double-slash \\\\\\triple-slash
<h2>List</h2>
列表示例:
<ol>
    <li><img src="images/2.jpg" alt="test alt attribute" width="30" height="30" border="0" /> test image</li>
    <li><b>bold text</b></li>
    <li><i>italic text</i></li>
    <li><u>underlined text</u></li>
    <li><b>b<i>bi<u>biu</u>bi</i>b</b></li>
    <li><a href="http://www.tecnick.com" dir="ltr">link to http://www.tecnick.com</a></li>
    <li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.<br />Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</li>
    <li>SUBLIST
        <ol>
            <li>row one
                <ul>
                    <li>sublist</li>
                </ul>
            </li>
            <li>row two</li>
        </ol>
    </li>
    <li><b>T</b>E<i>S</i><u>T</u> <del>line through</del></li>
    <li><font size="+3">font + 3</font></li>
    <li><small>small text</small> normal <small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal</li>
</ol>
<dl>
    <dt>Coffee</dt>
    <dd>Black hot drink</dd>
    <dt>Milk</dt>
    <dd>White cold drink</dd>
</dl>
<div style="text-align:center">IMAGES<br />
<img src="images/2.jpg" alt="test alt attribute" width="100" height="100" border="0" />
<img src="images/2.jpg" alt="test alt attribute" width="100" height="100" border="0" />
<img src="images/2.jpg" alt="test alt attribute" width="100" height="100" border="0" />
</div>';
// Html输出
// 说明:
// P1:显示文本
// P2:如果为真，则在文本后添加新行
// P3:设置背景必须绘制还是透明
// P4:如果为真，重置最后一个单元格高度
// P5:如果为true，则在每次写入中添加当前的左（或右）填充（默认为false）
$pdf->writeHTML($html, true, false, true, false, '');

// 测试一些内联CSS
$html = '<p>This is just an example of html code to demonstrate some supported CSS inline styles.
<span style="font-weight: bold;">bold text</span>
<span style="text-decoration: line-through;">line-trough</span>
<span style="text-decoration: underline line-through;">underline and line-trough</span>
<span style="color: rgb(0, 128, 64);">color</span>
<span style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">background color</span>
<span style="font-weight: bold;">bold</span>
<span style="font-size: xx-small;">xx-small</span>
<span style="font-size: x-small;">x-small</span>
<span style="font-size: small;">small</span>
<span style="font-size: medium;">medium</span>
<span style="font-size: large;">large</span>
<span style="font-size: x-large;">x-large</span>
<span style="font-size: xx-large;">xx-large</span>
</p>';
$pdf->writeHTML($html, true, false, true, false, '');
// 重置指向最后一个文档页的指针
$pdf->lastPage();

// 打印Table表格
$pdf->AddPage();
$html = '<h1>Image alignments on HTML table</h1>
<table cellpadding="1" cellspacing="1" border="1" style="text-align:center;">
<tr><td><img src="images/logo_example.png" border="0" height="41" width="41" /></td></tr>
<tr style="text-align:left;"><td><img src="images/logo_example.png" border="0" height="41" width="41" align="top" /></td></tr>
<tr style="text-align:center;"><td><img src="images/logo_example.png" border="0" height="41" width="41" align="middle" /></td></tr>
<tr style="text-align:right;"><td><img src="images/logo_example.png" border="0" height="41" width="41" align="bottom" /></td></tr>
<tr><td style="text-align:left;"><img src="images/logo_example.png" border="0" height="41" width="41" align="top" /></td></tr>
<tr><td style="text-align:center;"><img src="images/logo_example.png" border="0" height="41" width="41" align="middle" /></td></tr>
<tr><td style="text-align:right;"><img src="images/logo_example.png" border="0" height="41" width="41" align="bottom" /></td></tr>
</table>';
$pdf->writeHTML($html, true, false, true, false, '');


// 打印所有HTML颜色
$pdf->AddPage();
$textcolors = '<h1>HTML Text Colors</h1>';
$bgcolors = '<hr /><h1>HTML Background Colors</h1>';
foreach (TCPDF_COLORS::$webcolor as $k => $v) {
    $textcolors .= '<span color="#' . $v . '">' . $v . '</span> ';
    $bgcolors .= '<span bgcolor="#' . $v . '" color="#333333">' . $v . '</span> ';
}
$pdf->writeHTML($textcolors, true, false, true, false, '');
$pdf->writeHTML($bgcolors, true, false, true, false, '');


$pdf->AddPage();
// 测试字包
$html = '<h1>测试字包</h1>
<a href="#2">锚点:连接到第二页</a><br />
<font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font> <font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font> <font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font> <font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font> <font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font>';
$pdf->writeHTML($html, true, false, true, false, '');


// 测试字体嵌套
$pdf->AddPage();
$html1 = '测试字体嵌套 <font face="courier">Courier <font face="helvetica">Helvetica <font face="times">Times <font face="dejavusans">dejavusans </font>Times </font>Helvetica </font>Courier </font>Default';
$html2 = '<small>small text</small> normal <small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal';
$html3 = '<font size="10" color="#ff7f50">The</font> <font size="10" color="#6495ed">quick</font> <font size="14" color="#dc143c">brown</font> <font size="18" color="#008000">fox</font> <font size="22"><a href="http://www.tcpdf.org">jumps</a></font> <font size="22" color="#a0522d">over</font> <font size="18" color="#da70d6">the</font> <font size="14" color="#9400d3">lazy</font> <font size="10" color="#4169el">dog</font>.';
$html = $html1 . '<br />' . $html2 . '<br />' . $html3 . '<br />' . $html3 . '<br />' . $html2;
$pdf->writeHTML($html, true, false, true, false, '');


// 测试预标记
$pdf->AddPage();
$html = <<<EOF
<div style="background-color:#880000;color:white;">
Hello World!<br />
Hello
</div>
<pre style="background-color:#336699;color:white;">
int main() {
    printf("HelloWorld");
    return 0;
}
</pre>
<tt>Monospace font</tt>, normal font, <tt>monospace font</tt>, normal font.
<br />
<div style="background-color:#880000;color:white;">DIV LEVEL 1<div style="background-color:#008800;color:white;">DIV LEVEL 2</div>DIV LEVEL 1</div>
<br />
<span style="background-color:#880000;color:white;">SPAN LEVEL 1 <span style="background-color:#008800;color:white;">SPAN LEVEL 2</span> SPAN LEVEL 1</span>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

// 测试列表的自定义项目符号点
$pdf->AddPage();
$html = <<<EOF
<h1>测试列表的自定义项目符号点</h1>
<ul style="font-size:14pt;list-style-type:img|png|4|4|images/logo_example.png">
    <li>test custom bullet image</li>
    <li>test custom bullet image</li>
    <li>test custom bullet image</li>
    <li>test custom bullet image</li>
<ul>
EOF;
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$html = '

<table border="0" >
  <tr>
    <td rowspan="2"> <img src="images/2.jpg" alt="test alt attribute" width="100" height="100" border="0" /></td>
    <td height="50">test image test image</td>
    <td  height="50">test image test image</td>
  </tr>
  <tr>
    <td  height="50">test image test image</td>
    <td  height="50">test image test image</td>
  </tr>
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();

// 输出
// 说明:
// P1:pdf名称 P2:输出方式['I':直接输出到浏览器 'D':浏览器下载，文件名默认为定义的文件名 'F':指定名称保存到服务器  'S':以字符串形式返回文档（忽略名称）'FI':相反与F和I的组合]
$pdf->Output('20190123.pdf', 'I');
// $pdf->Output(K_PATH_IMAGES . '20190123.pdf', 'FI');