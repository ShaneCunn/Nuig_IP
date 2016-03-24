<?php
require_once( dirname(__FILE__).'/form.lib.php' );

define( 'PHPFMG_USER', "shanecunningham@live.ie" ); // must be a email address. for sending password to you.
define( 'PHPFMG_PW', "96d511" );

?>
<?php
/**
 * GNU Library or Lesser General Public License version 2.0 (LGPLv2)
*/

# main
# ------------------------------------------------------
error_reporting( E_ERROR ) ;
phpfmg_admin_main();
# ------------------------------------------------------




function phpfmg_admin_main(){
    $mod  = isset($_REQUEST['mod'])  ? $_REQUEST['mod']  : '';
    $func = isset($_REQUEST['func']) ? $_REQUEST['func'] : '';
    $function = "phpfmg_{$mod}_{$func}";
    if( !function_exists($function) ){
        phpfmg_admin_default();
        exit;
    };

    // no login required modules
    $public_modules   = false !== strpos('|captcha|', "|{$mod}|", "|ajax|");
    $public_functions = false !== strpos('|phpfmg_ajax_submit||phpfmg_mail_request_password||phpfmg_filman_download||phpfmg_image_processing||phpfmg_dd_lookup|', "|{$function}|") ;   
    if( $public_modules || $public_functions ) { 
        $function();
        exit;
    };
    
    return phpfmg_user_isLogin() ? $function() : phpfmg_admin_default();
}

function phpfmg_ajax_submit(){
    $phpfmg_send = phpfmg_sendmail( $GLOBALS['form_mail'] );
    $isHideForm  = isset($phpfmg_send['isHideForm']) ? $phpfmg_send['isHideForm'] : false;

    $response = array(
        'ok' => $isHideForm,
        'error_fields' => isset($phpfmg_send['error']) ? $phpfmg_send['error']['fields'] : '',
        'OneEntry' => isset($GLOBALS['OneEntry']) ? $GLOBALS['OneEntry'] : '',
    );
    
    @header("Content-Type:text/html; charset=$charset");
    echo "<html><body><script>
    var response = " . json_encode( $response ) . ";
    try{
        parent.fmgHandler.onResponse( response );
    }catch(E){};
    \n\n";
    echo "\n\n</script></body></html>";

}


function phpfmg_admin_default(){
    if( phpfmg_user_login() ){
        phpfmg_admin_panel();
    };
}



function phpfmg_admin_panel()
{    
    phpfmg_admin_header();
    phpfmg_writable_check();
?>    
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign=top style="padding-left:280px;">

<style type="text/css">
    .fmg_title{
        font-size: 16px;
        font-weight: bold;
        padding: 10px;
    }
    
    .fmg_sep{
        width:32px;
    }
    
    .fmg_text{
        line-height: 150%;
        vertical-align: top;
        padding-left:28px;
    }

</style>

<script type="text/javascript">
    function deleteAll(n){
        if( confirm("Are you sure you want to delete?" ) ){
            location.href = "admin.php?mod=log&func=delete&file=" + n ;
        };
        return false ;
    }
</script>


<div class="fmg_title">
    1. Email Traffics
</div>
<div class="fmg_text">
    <a href="admin.php?mod=log&func=view&file=1">view</a> &nbsp;&nbsp;
    <a href="admin.php?mod=log&func=download&file=1">download</a> &nbsp;&nbsp;
    <?php 
        if( file_exists(PHPFMG_EMAILS_LOGFILE) ){
            echo '<a href="#" onclick="return deleteAll(1);">delete all</a>';
        };
    ?>
</div>


<div class="fmg_title">
    2. Form Data
</div>
<div class="fmg_text">
    <a href="admin.php?mod=log&func=view&file=2">view</a> &nbsp;&nbsp;
    <a href="admin.php?mod=log&func=download&file=2">download</a> &nbsp;&nbsp;
    <?php 
        if( file_exists(PHPFMG_SAVE_FILE) ){
            echo '<a href="#" onclick="return deleteAll(2);">delete all</a>';
        };
    ?>
</div>

<div class="fmg_title">
    3. Form Generator
</div>
<div class="fmg_text">
    <a href="http://www.formmail-maker.com/generator.php" onclick="document.frmFormMail.submit(); return false;" title="<?php echo htmlspecialchars(PHPFMG_SUBJECT);?>">Edit Form</a> &nbsp;&nbsp;
    <a href="http://www.formmail-maker.com/generator.php" >New Form</a>
</div>
    <form name="frmFormMail" action='http://www.formmail-maker.com/generator.php' method='post' enctype='multipart/form-data'>
    <input type="hidden" name="uuid" value="<?php echo PHPFMG_ID; ?>">
    <input type="hidden" name="external_ini" value="<?php echo function_exists('phpfmg_formini') ?  phpfmg_formini() : ""; ?>">
    </form>

		</td>
	</tr>
</table>

<?php
    phpfmg_admin_footer();
}



function phpfmg_admin_header( $title = '' ){
    header( "Content-Type: text/html; charset=" . PHPFMG_CHARSET );
?>
<html>
<head>
    <title><?php echo '' == $title ? '' : $title . ' | ' ; ?>PHP FormMail Admin Panel </title>
    <meta name="keywords" content="PHP FormMail Generator, PHP HTML form, send html email with attachment, PHP web form,  Free Form, Form Builder, Form Creator, phpFormMailGen, Customized Web Forms, phpFormMailGenerator,formmail.php, formmail.pl, formMail Generator, ASP Formmail, ASP form, PHP Form, Generator, phpFormGen, phpFormGenerator, anti-spam, web hosting">
    <meta name="description" content="PHP formMail Generator - A tool to ceate ready-to-use web forms in a flash. Validating form with CAPTCHA security image, send html email with attachments, send auto response email copy, log email traffics, save and download form data in Excel. ">
    <meta name="generator" content="PHP Mail Form Generator, phpfmg.sourceforge.net">

    <style type='text/css'>
    body, td, label, div, span{
        font-family : Verdana, Arial, Helvetica, sans-serif;
        font-size : 12px;
    }
    </style>
</head>
<body  marginheight="0" marginwidth="0" leftmargin="0" topmargin="0">

<table cellspacing=0 cellpadding=0 border=0 width="100%">
    <td nowrap align=center style="background-color:#024e7b;padding:10px;font-size:18px;color:#ffffff;font-weight:bold;width:250px;" >
        Form Admin Panel
    </td>
    <td style="padding-left:30px;background-color:#86BC1B;width:100%;font-weight:bold;" >
        &nbsp;
<?php
    if( phpfmg_user_isLogin() ){
        echo '<a href="admin.php" style="color:#ffffff;">Main Menu</a> &nbsp;&nbsp;' ;
        echo '<a href="admin.php?mod=user&func=logout" style="color:#ffffff;">Logout</a>' ;
    }; 
?>
    </td>
</table>

<div style="padding-top:28px;">

<?php
    
}


function phpfmg_admin_footer(){
?>

</div>

<div style="color:#cccccc;text-decoration:none;padding:18px;font-weight:bold;">
	:: <a href="http://phpfmg.sourceforge.net" target="_blank" title="Free Mailform Maker: Create read-to-use Web Forms in a flash. Including validating form with CAPTCHA security image, send html email with attachments, send auto response email copy, log email traffics, save and download form data in Excel. " style="color:#cccccc;font-weight:bold;text-decoration:none;">PHP FormMail Generator</a> ::
</div>

</body>
</html>
<?php
}


function phpfmg_image_processing(){
    $img = new phpfmgImage();
    $img->out_processing_gif();
}


# phpfmg module : captcha
# ------------------------------------------------------
function phpfmg_captcha_get(){
    $img = new phpfmgImage();
    $img->out();
    //$_SESSION[PHPFMG_ID.'fmgCaptchCode'] = $img->text ;
    $_SESSION[ phpfmg_captcha_name() ] = $img->text ;
}



function phpfmg_captcha_generate_images(){
    for( $i = 0; $i < 50; $i ++ ){
        $file = "$i.png";
        $img = new phpfmgImage();
        $img->out($file);
        $data = base64_encode( file_get_contents($file) );
        echo "'{$img->text}' => '{$data}',\n" ;
        unlink( $file );
    };
}


function phpfmg_dd_lookup(){
    $paraOk = ( isset($_REQUEST['n']) && isset($_REQUEST['lookup']) && isset($_REQUEST['field_name']) );
    if( !$paraOk )
        return;
        
    $base64 = phpfmg_dependent_dropdown_data();
    $data = @unserialize( base64_decode($base64) );
    if( !is_array($data) ){
        return ;
    };
    
    
    foreach( $data as $field ){
        if( $field['name'] == $_REQUEST['field_name'] ){
            $nColumn = intval($_REQUEST['n']);
            $lookup  = $_REQUEST['lookup']; // $lookup is an array
            $dd      = new DependantDropdown(); 
            echo $dd->lookupFieldColumn( $field, $nColumn, $lookup );
            return;
        };
    };
    
    return;
}


function phpfmg_filman_download(){
    if( !isset($_REQUEST['filelink']) )
        return ;
        
    $info =  @unserialize(base64_decode($_REQUEST['filelink']));
    if( !isset($info['recordID']) ){
        return ;
    };
    
    $file = PHPFMG_SAVE_ATTACHMENTS_DIR . $info['recordID'] . '-' . $info['filename'];
    phpfmg_util_download( $file, $info['filename'] );
}


class phpfmgDataManager
{
    var $dataFile = '';
    var $columns = '';
    var $records = '';
    
    function phpfmgDataManager(){
        $this->dataFile = PHPFMG_SAVE_FILE; 
    }
    
    function parseFile(){
        $fp = @fopen($this->dataFile, 'rb');
        if( !$fp ) return false;
        
        $i = 0 ;
        $phpExitLine = 1; // first line is php code
        $colsLine = 2 ; // second line is column headers
        $this->columns = array();
        $this->records = array();
        $sep = chr(0x09);
        while( !feof($fp) ) { 
            $line = fgets($fp);
            $line = trim($line);
            if( empty($line) ) continue;
            $line = $this->line2display($line);
            $i ++ ;
            switch( $i ){
                case $phpExitLine:
                    continue;
                    break;
                case $colsLine :
                    $this->columns = explode($sep,$line);
                    break;
                default:
                    $this->records[] = explode( $sep, phpfmg_data2record( $line, false ) );
            };
        }; 
        fclose ($fp);
    }
    
    function displayRecords(){
        $this->parseFile();
        echo "<table border=1 style='width=95%;border-collapse: collapse;border-color:#cccccc;' >";
        echo "<tr><td>&nbsp;</td><td><b>" . join( "</b></td><td>&nbsp;<b>", $this->columns ) . "</b></td></tr>\n";
        $i = 1;
        foreach( $this->records as $r ){
            echo "<tr><td align=right>{$i}&nbsp;</td><td>" . join( "</td><td>&nbsp;", $r ) . "</td></tr>\n";
            $i++;
        };
        echo "</table>\n";
    }
    
    function line2display( $line ){
        $line = str_replace( array('"' . chr(0x09) . '"', '""'),  array(chr(0x09),'"'),  $line );
        $line = substr( $line, 1, -1 ); // chop first " and last "
        return $line;
    }
    
}
# end of class



# ------------------------------------------------------
class phpfmgImage
{
    var $im = null;
    var $width = 73 ;
    var $height = 33 ;
    var $text = '' ; 
    var $line_distance = 8;
    var $text_len = 4 ;

    function phpfmgImage( $text = '', $len = 4 ){
        $this->text_len = $len ;
        $this->text = '' == $text ? $this->uniqid( $this->text_len ) : $text ;
        $this->text = strtoupper( substr( $this->text, 0, $this->text_len ) );
    }
    
    function create(){
        $this->im = imagecreate( $this->width, $this->height );
        $bgcolor   = imagecolorallocate($this->im, 255, 255, 255);
        $textcolor = imagecolorallocate($this->im, 0, 0, 0);
        $this->drawLines();
        imagestring($this->im, 5, 20, 9, $this->text, $textcolor);
    }
    
    function drawLines(){
        $linecolor = imagecolorallocate($this->im, 210, 210, 210);
    
        //vertical lines
        for($x = 0; $x < $this->width; $x += $this->line_distance) {
          imageline($this->im, $x, 0, $x, $this->height, $linecolor);
        };
    
        //horizontal lines
        for($y = 0; $y < $this->height; $y += $this->line_distance) {
          imageline($this->im, 0, $y, $this->width, $y, $linecolor);
        };
    }
    
    function out( $filename = '' ){
        if( function_exists('imageline') ){
            $this->create();
            if( '' == $filename ) header("Content-type: image/png");
            ( '' == $filename ) ? imagepng( $this->im ) : imagepng( $this->im, $filename );
            imagedestroy( $this->im ); 
        }else{
            $this->out_predefined_image(); 
        };
    }

    function uniqid( $len = 0 ){
        $md5 = md5( uniqid(rand()) );
        return $len > 0 ? substr($md5,0,$len) : $md5 ;
    }
    
    function out_predefined_image(){
        header("Content-type: image/png");
        $data = $this->getImage(); 
        echo base64_decode($data);
    }
    
    // Use predefined captcha random images if web server doens't have GD graphics library installed  
    function getImage(){
        $images = array(
			'D8CC' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAW0lEQVR4nGNYhQEaGAYTpIn7QgMYQxhCHaYGIIkFTGFtZXQICBBBFmsVaXRtEHRgQRFjbWVtYHRAdl/U0pVhS1etzEJ2H5o6JPOwiaHZgcUt2Nw8UOFHRYjFfQDrZMzF/c2jhQAAAABJRU5ErkJggg==',
			'4E77' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpI37poiGsoYGhoYgi4WIAMmABhEkMUYsYqxTgLxGB6Aown3Tpk0NW7V01cosJPcFgNRNYWhFtjc0FCgWABRFcYtIA6MDUBRNjBUkiu5mdLGBCj/qQSzuAwBujcs1VNUahwAAAABJRU5ErkJggg==',
			'0B92' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7GB1EQxhCGaY6IImxBoi0Mjo6BAQgiYlMEWl0bQh0EEESC2gVaWVtCGgQQXJf1NKpYSszo1ZFIbkPpI4hJKDRAVUvkB/QyoBmh2NDwBQGLG7BdDNjaMggCD8qQizuAwAlpcwkbCnhPAAAAABJRU5ErkJggg==',
			'64CE' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7WAMYWhlCHUMDkMREpjBMZXQIdEBWF9DCEMraIIgq1sDoytrACBMDOykyaunSpatWhmYhuS9kikgrkjqI3lbRUFcMMYZWdDuAbmlFdws2Nw9U+FERYnEfACejyc7c3fmoAAAAAElFTkSuQmCC',
			'4EB5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpI37poiGsoYyhgYgi4WINLA2Ojogq2MEiTUEooixTgGrc3VAct+0aVPDloaujIpCcl8AWJ1DgwiS3tBQkHkBKGIMUyB2YIg1OgSguA/sZoapDoMh/KgHsbgPACJLy6RxmcFOAAAAAElFTkSuQmCC',
			'38A6' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7RAMYQximMEx1QBILmMLayhDKEBCArLJVpNHR0dFBAFkMqI61IdAB2X0ro1aGLV0VmZqF7D6IOgzzXEMDHUTQxRpQxQLAegNQ9ILcDBRDcfNAhR8VIRb3AQAU/8xjFVjATQAAAABJRU5ErkJggg==',
			'513C' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7QkMYAhhDGaYGIIkFNDAGsDY6BIigiLEGMDQEOrAgiQUGMAQwNDo6ILsvbNqqqFVTV2ahuK8VRR1CDGgeslgAVAzZDpEpDBhuYQ1gDUV380CFHxUhFvcBAHxZyeZu3SRbAAAAAElFTkSuQmCC',
			'77C3' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7QkNFQx1AEFm0laHR0SHQIQBNzLVBoEEEWWwKQysrkA5Adl/UqmlLV61amoXkPkYHhgAkdWDIChQFiSGbJwIUZUWzIwDIY0RzC0iMAd3NAxR+VIRY3AcAky3MdUV8s0oAAAAASUVORK5CYII=',
			'6BB9' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7WANEQ1hDGaY6IImJTBFpZW10CAhAEgtoEWl0bQh0EEEWawCpc4SJgZ0UGTU1bGnoqqgwJPeFQMybiqK3FWQe0ARMMRQ7sLkFm5sHKvyoCLG4DwDHyc2S8zxrPAAAAABJRU5ErkJggg==',
			'B5AD' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7QgNEQxmmMIY6IIkFTBFpYAhldAhAFmsVaWB0dHQQQVUXwtoQCBMDOyk0aurSpasis6YhuS9gCkOjK0Id1DygWCi6mAimuimsrSA7kN0SGsAIshfFzQMVflSEWNwHAKBAzZophqONAAAAAElFTkSuQmCC',
			'736D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7QkNZQxhCGUMdkEVbRVoZHR0dAlDEGBpdGxwdRJDFpjC0sjYwwsQgbopaFbZ06sqsaUjuY3QAqnNE1cvaADIvEEVMBItYQAOmWwIasLh5gMKPihCL+wA3XcrEh/nXaQAAAABJRU5ErkJggg==',
			'BA75' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7QgMYAlhDA0MDkMQCpjCGMDQEOiCrC2hlbcUQmyLS6NDo6OqA5L7QqGkrs5aujIpCch9Y3RSGBhEU80RDHQLQxUQaHR0YHUTQ7HBtYAhAdl9oAFhsqsMgCD8qQizuAwD/c83aJt1HfgAAAABJRU5ErkJggg==',
			'890B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7WAMYQximMIY6IImJTGFtZQhldAhAEgtoFWl0dHR0EEFRJ9Lo2hAIUwd20tKopUtTV0WGZiG5T2QKYyCSOqh5DGC9IihiLFjswHQLNjcPVPhREWJxHwCtBsvIthqKfQAAAABJRU5ErkJggg==',
			'F2D3' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAY0lEQVR4nGNYhQEaGAYTpIn7QkMZQ1hDGUIdkMQCGlhbWRsdHQJQxEQaXUEkihgDWCwAyX2hUauWLl0VtTQLyX1A+SmsCHUwsQBWDPMYHTDFWBsw3SIa6orm5oEKPypCLO4DALY5zwU6wyuFAAAAAElFTkSuQmCC',
			'5CF5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7QkMYQ1lDA0MDkMQCGlgbXRsYHRhQxEQa0MUCA0QaWBsYXR2Q3Bc2bdqqpaEro6KQ3dcKUscANAFJNxaxgFaIHchiIlNAbmEIQHYfawDQzQ0MUx0GQfhREWJxHwCFDsuiAP+S7wAAAABJRU5ErkJggg==',
			'4469' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpI37pjC0MoQyTHVAFgthmMro6BAQgCTGGMIQytrg6CCCJMY6hdGVtYERJgZ20rRpS5cunboqKgzJfQFTRFpZHR2mIusNDRUNdW0IaBBBcwtrQ4ADuhi6W7C6eaDCj3oQi/sAxDXLSaFqC/sAAAAASUVORK5CYII=',
			'FCE6' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAWklEQVR4nGNYhQEaGAYTpIn7QkMZQ1lDHaY6IIkFNLA2ujYwBASgiIk0uDYwOgigibECxZDdFxo1bdXS0JWpWUjug6rDMA+kVwSLHSIE3YLp5oEKPypCLO4DADTzzRDF+WxaAAAAAElFTkSuQmCC',
			'1BA4' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7GB1EQximMDQEIImxOoi0MoQyNCKLiTqINDo6OrQGoOgVaWVtCJgSgOS+lVlTw5auioqKQnIfRF2gA5reRtfQwNAQdDGgS7DYgSImGiIagi42UOFHRYjFfQC+mcwnOJIaagAAAABJRU5ErkJggg==',
			'D01B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7QgMYAhimMIY6IIkFTGEMYQhhdAhAFmtlbWUEiomgiIk0OkyBqwM7KWrptJVZ01aGZiG5D00dipgImh0M6GIgt6DpBbmZMdQRxc0DFX5UhFjcBwAWB8wvjuWlegAAAABJRU5ErkJggg==',
			'1CFA' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7GB0YQ1lDA1qRxVgdWBtdGximOiCJiTqINADFAgJQ9Io0sIJJhPtWZk1btTQURCLch6YOWSw0BE3MFUMdyC2oYqIhQDejiQ1U+FERYnEfANR5yIWtrLM1AAAAAElFTkSuQmCC',
			'0F52' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7GB1EQ11DHaY6IImxBog0sDYwBAQgiYlMAYkxOoggiQW0AsWmAuWQ3Be1dGrY0sysVVFI7gOpA5KNDmh6QSQDhh0BUxjQ3MLo6BCA6mag3lDG0JBBEH5UhFjcBwCnQsuyAyfZbwAAAABJRU5ErkJggg==',
			'42C8' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdElEQVR4nGNYhQEaGAYTpI37pjCGMIQ6THVAFgthbWV0CAgIQBJjDBFpdG0QdBBBEmOdwgAUY4CpAztp2rRVS5euWjU1C8l9AVMYprAi1IFhaChDAGsDI4p5QLc4sKLZAdKJ7haGKaKhDuhuHqjwox7E4j4AsYnL1RL3sBsAAAAASUVORK5CYII=',
			'29A0' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAd0lEQVR4nGNYhQEaGAYTpIn7WAMYQximMLQii4lMYW1lCGWY6oAkFtAq0ujo6BAQgKwbKObaEOggguy+aUuXpq6KzJqG7L4AxkAkdWDI6MDQ6BqKKsbawAI0LwDFDpEG1lbWhgAUt4SGMoYAxVDcPFDhR0WIxX0AbyfMmTQgilYAAAAASUVORK5CYII=',
			'B3C9' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAY0lEQVR4nGNYhQEaGAYTpIn7QgNYQxhCHaY6IIkFTBFpZXQICAhAFmtlaHRtEHQQQVHH0MrawAgTAzspNGpV2NJVq6LCkNwHUccwVQTDPIYGTDEBNDsw3YLNzQMVflSEWNwHAI77zVciHAefAAAAAElFTkSuQmCC',
			'AFCC' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7GB1EQx1CHaYGIImxBogAxQOAJEJMZIpIA2uDoAMLklhAK0iM0QHZfVFLp4YtXbUyC9l9aOrAMDQUUwyiDtMOdLeAxBjQ3DxQ4UdFiMV9AAYCy4C9Vq6UAAAAAElFTkSuQmCC',
			'6653' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7WAMYQ1hDHUIdkMREprC2sjYwOgQgiQW0iDSyguSQxYA81qkgGuG+yKhpYUszs5ZmIbkvZIpoK0gVinmtIo0OYBNQxVzRxEBuYXR0RHELyM0MoQwobh6o8KMixOI+ABK8zP5mpXtaAAAAAElFTkSuQmCC',
			'A5F6' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7GB1EQ1lDA6Y6IImxBog0sDYwBAQgiYlMAYkxOgggiQW0ioSAxJDdF7V06tKloStTs5DcF9DK0OjawIhiXmgoWMxBBNU8LGKsrehuCWhlBNrLgOLmgQo/KkIs7gMAVSrL0LZh3N8AAAAASUVORK5CYII=',
			'C197' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7WEMYAhhCGUNDkMREWhkDGB0dGkSQxAIaWQNYGwJQxRoYwGIBSO6LAqKVmVErs5DcB1LHEBLQyoCmF0hOQRFrZAhgbAgIYEBxC1DM0dEB1c2soUA3o4gNVPhREWJxHwCDm8nSsFcrzQAAAABJRU5ErkJggg==',
			'6D9F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYklEQVR4nGNYhQEaGAYTpIn7WANEQxhCGUNDkMREpoi0Mjo6OiCrC2gRaXRtCEQVa0ARAzspMmrayszMyNAsJPeFTBFpdAhB09sKFEM3DyjmiCaGzS1QN6OIDVT4URFicR8AmubK08ra1LEAAAAASUVORK5CYII=',
			'2D3E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7WANEQxhDGUMDkMREpoi0sjY6OiCrC2gVaXRoCEQRYwCJIdRB3DRt2sqsqStDs5DdF4CiDgwZHTDNY23AFBNpwHRLaCimmwcq/KgIsbgPAAuly0bfQP/SAAAAAElFTkSuQmCC',
			'218B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7WAMYAhhCGUMdkMREpjAGMDo6OgQgiQW0sgawNgQ6iCDrbmVAVgdx07RVUatCV4ZmIbsvgAHDPEYHBgzzWBswxYBsDL2hoayh6G4eqPCjIsTiPgAVIMghRsEpDgAAAABJRU5ErkJggg==',
			'A31F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7GB1YQximMIaGIImxBoi0MoQwOiCrE5nC0OiIJhbQytAK1AsTAzspaumqsFXTVoZmIbkPTR0YhoYyNDpMwTAPi5gIht6AVtYQxlBHFLGBCj8qQizuAwCkQMmd/Wb2iQAAAABJRU5ErkJggg==',
			'F1F2' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYklEQVR4nGNYhQEaGAYTpIn7QkMZAlhDA6Y6IIkFNDAGsDYwBASgiLECxRgdRFDEGEDqGkSQ3BcatSpqaeiqVVFI7oOqa3TA1NvKgCk2BYtYAKoYayjQLaEhgyD8qAixuA8AZ7XKtPu+n8sAAAAASUVORK5CYII=',
			'9CB9' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7WAMYQ1lDGaY6IImJTGFtdG10CAhAEgtoFWlwbQh0EEETY210hImBnTRt6rRVS0NXRYUhuY/VFaTOYSqyXgaQ3oaABmQxAbAdASh2YHMLNjcPVPhREWJxHwBf3s0eHCSnXQAAAABJRU5ErkJggg==',
			'0B12' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7GB1EQximMEx1QBJjDRBpZQhhCAhAEhOZItLoGMLoIIIkFtAKVDcFKIfkvqilU8NWTQPSSO6Dqmt0QNXb6DCFoZUBzQ6g2BQGdLdMYQhAdzNjqGNoyCAIPypCLO4DAIsgy7yUVqypAAAAAElFTkSuQmCC',
			'B43A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7QgMYWhlDGVqRxQKmMExlbXSY6oAs1soQCiQDAlDUMboyNDo6iCC5LzRq6dJVU1dmTUNyX8AUkVYkdVDzREMdGgJDQ1DtALojEFXdFIZWVjS9EDczoogNVPhREWJxHwD/qc2Dyyt3oAAAAABJRU5ErkJggg==',
			'0AD1' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7GB0YAlhDGVqRxVgDGENYGx2mIouJTGFtZW0ICEUWC2gVaXQFksjui1o6bWUqkER2H5o6qJhoKLqYyBRMdawBQLFGBxQxRgegWChDaMAgCD8qQizuAwAlks1UMHIflAAAAABJRU5ErkJggg==',
			'5BAB' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7QkNEQximMIY6IIkFNIi0MoQyOgSgijU6Ojo6iCCJBQaItLI2BMLUgZ0UNm1q2NJVkaFZyO5rRVEHE2t0DQ1EMS8AJNaAKiYyBVMva4BoCFAMxc0DFX5UhFjcBwCtC8yx/X/zrwAAAABJRU5ErkJggg==',
			'6458' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdklEQVR4nGNYhQEaGAYTpIn7WAMYWllDHaY6IImJTGGYytrAEBCAJBbQwhDK2sDoIIIs1sDoyjoVrg7spMiopUuXZmZNzUJyX8gUkVagalTzWkVDHRoCUc1rBboFTQzollZGRwcUvSA3M4QyoLh5oMKPihCL+wAT+8wpNJdH6wAAAABJRU5ErkJggg==',
			'04EE' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAW0lEQVR4nGNYhQEaGAYTpIn7GB0YWllDHUMDkMRYAximsoJkkMREpjCEoosFtDK6IomBnRS1FAhCV4ZmIbkvoFWkFVOvaKgrph0Y6oBuwRDD5uaBCj8qQizuAwBfqshiruxzqwAAAABJRU5ErkJggg==',
			'3127' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7RAMYAhhCGUNDkMQCpjAGMDo6NIggq2xlDWBtCEAVmwLUCxQLQHLfyqhVUatWZq3MQnYfSF0rEKKYBxSbAoToYiCI4haGAEYHRgdUN7OGsoYGoogNVPhREWJxHwApncio5yG2mwAAAABJRU5ErkJggg==',
			'4C4A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpI37pjCGMjQ6tKKIhbACRRymOiCJMYaINABFAgKQxFiniDQwBDo6iCC5b9q0aatWZmZmTUNyXwBQHWsjXB0YhoYCxUIDQ0NQ3AK0A00dwxSgWzDEQG5GExuo8KMexOI+ABjYzNrGuJt5AAAAAElFTkSuQmCC',
			'5281' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7QkMYQxhCGVqRxQIaWFsZHR2mooqJNLo2BIQiiwUGMDQ6OjrA9IKdFDZt1dJVoUCM7L5WhimMCHUwsQDWhgBUe1sZHdDFRKawNqDrZQ0QDXUIZQgNGAThR0WIxX0A+o3L663IEjUAAAAASUVORK5CYII=',
			'8550' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7WANEQ1lDHVqRxUSmiDSwNjBMdUASC2gFiwUEoKoLYZ3K6CCC5L6lUVOXLs3MzJqG5D6RKQyNDg2BMHVQ87CJiTS6NgSg2cHayujogOIW1gDGEIZQBhQ3D1T4URFicR8Aa33MccEaUHEAAAAASUVORK5CYII=',
			'4625' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAd0lEQVR4nM2QsQ2AMAwE7SIbhH1MQW+kmCIbsEUosoHJDmRKUjqCEqT4JRcnWzo91MckGCn/+CkGEBS2LLiM80z2DoM/XFo75tS3vS5k/EopW732GI0f65QhQ/LmV8QfpD0DbYyRetZcCLjza85O+KQR+vsuL343zlfKjp5NJuYAAAAASUVORK5CYII=',
			'7F36' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAY0lEQVR4nGNYhQEaGAYTpIn7QkNFQx1DGaY6IIu2ijSwNjoEBKCJMTQEOgggi00BijU6OqC4L2pq2KqpK1OzkNzH6ABWh2IeawPEPBEkMREsYgENmG4BiTGiu3mAwo+KEIv7AFevzG731CYHAAAAAElFTkSuQmCC',
			'A519' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdUlEQVR4nGNYhQEaGAYTpIn7GB1EQxmmMEx1QBJjDRBpYAhhCAhAEhOZItLAGMLoIIIkFtAqEsIwBS4GdlLU0qlLV01bFRWG5L6AVoZGB6AdyHpDQ8FiDWjmgcTQ7GBtBboPxS0BrUCXhDqguHmgwo+KEIv7AKs1zDvbdxOUAAAAAElFTkSuQmCC',
			'A3B1' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAY0lEQVR4nGNYhQEaGAYTpIn7GB1YQ1hDGVqRxVgDRFpZGx2mIouJTGFodG0ICEUWC2hlAKmD6QU7KWrpqrCloauWIrsPTR0YhoaCzWtFMw+LmAiG3oBWsJtDAwZB+FERYnEfAFAzzXc/KS4cAAAAAElFTkSuQmCC',
			'85D6' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7WANEQ1lDGaY6IImJTBFpYG10CAhAEgtoBYo1BDoIoKoLAYkhu29p1NSlS1dFpmYhuU9kCkOja0MgmnlgMQcRVDswxESmsLaiu4U1gDEE3c0DFX5UhFjcBwBBTs0kb/iHzAAAAABJRU5ErkJggg==',
			'20C2' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7WAMYAhhCHaY6IImJTGEMYXQICAhAEgtoZW1lbRB0EEHW3SrS6ApSj+y+adNWpgKpKGT3BYDVNSLbwegAFmtFcUsDyA6BKchiIg0QtyCLhYaC3OwYGjIIwo+KEIv7ACFNy0arvPf1AAAAAElFTkSuQmCC',
			'9FAC' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7WANEQx2mMEwNQBITmSLSwBDKECCCJBbQKtLA6OjowIImxtoQ6IDsvmlTp4YtXRWZhew+VlcUdRAI0huKKiYANQ/ZDpBbWBsCUNzCGgAWQ3HzQIUfFSEW9wEAPKLLjOdoRykAAAAASUVORK5CYII=',
			'7B9A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAc0lEQVR4nGNYhQEaGAYTpIn7QkNFQxhCGVpRRFtFWhkdHaY6oIo1ujYEBAQgi00RaWVtCHQQQXZf1NSwlZmRWdOQ3MfoINLKEAJXB4asDSKNDg2BoSFIYiJAMccGVHUBDSC3OKKJgdzMiCI2UOFHRYjFfQBo0suGSZ7JBgAAAABJRU5ErkJggg==',
			'7253' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAc0lEQVR4nGNYhQEaGAYTpIn7QkMZQ1hDHUIdkEVbWVtZGxgdAlDERBpdgbQIstgUhkbXqQwNAcjui1q1dGlm1tIsJPcxOgBVAlUhm8fawBAAEkM2TwSokhVNLACoktHREcUtAQ2iQBczoLp5gMKPihCL+wBaUcximXagDQAAAABJRU5ErkJggg==',
			'C182' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7WEMYAhhCGaY6IImJtDIGMDo6BAQgiQU0sgawNgQ6iCCLNTCA1DWIILkvCoRCwTTcfVB1jQ5oelkbAloZUOwAi01hQHELWG8AqptZQxlCGUNDBkH4URFicR8AwmTKOR+LZ20AAAAASUVORK5CYII=',
			'8669' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7WAMYQxhCGaY6IImJTGFtZXR0CAhAEgtoFWlkbXB0EEFRJ9LA2sAIEwM7aWnUtLClU1dFhSG5T2SKaCuro8NUETTzXBsCGrCIodmB6RZsbh6o8KMixOI+AM0kzAt31914AAAAAElFTkSuQmCC',
			'F094' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZUlEQVR4nGNYhQEaGAYTpIn7QkMZAhhCGRoCkMQCGhhDGB0dGlHFWFtZGwJaUcVEGl0bAqYEILkvNGrayszMqKgoJPeB1DmEBDqg63VoCAwNQbODEUhicQuaGKabByr8qAixuA8ATSHOwq4I4ZEAAAAASUVORK5CYII=',
			'3D74' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7RANEQ1hDAxoCkMQCpoi0AslGZDGGVpFGh4aAVhSxKUCxRocpAUjuWxk1bWXW0lVRUcjuA6mbwuiAYV4AY2gImpijAwOGW1gbUMXAbkYTG6jwoyLE4j4AlN3Or9mYzaAAAAAASUVORK5CYII=',
			'D255' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7QgMYQ1hDHUMDkMQCprC2sjYwOiCrC2gVaXTFEGNodJ3K6OqA5L6opauWLs3MjIpCch9Q3RQg2SCCqjcAU4zRgbUh0EEE1S0NjI4OAcjuCw0QDXUIZZjqMAjCj4oQi/sA/0LM8tSykuEAAAAASUVORK5CYII=',
			'818E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXUlEQVR4nGNYhQEaGAYTpIn7WAMYAhhCGUMDkMREpjAGMDo6OiCrC2hlDWBtCEQRE5nCgKwO7KSlUauiVoWuDM1Cch+aOqh5DBjmYRPDphfoklB0Nw9U+FERYnEfAHBvx6LwZOwdAAAAAElFTkSuQmCC',
			'5921' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcklEQVR4nGNYhQEaGAYTpIn7QkMYQxhCGVqRxQIaWFsZHR2mooqJNLo2BIQiiwUGiDQ6NATA9IKdFDZt6dKslVlLUdzXyhjo0IpqB5DX6DAFzd5WlkaHAFQxkSlAtzigirEGMIawhgaEBgyC8KMixOI+AD7VzBAzNYG1AAAAAElFTkSuQmCC',
			'91C4' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7WAMYAhhCHRoCkMREpjAGMDoENCKLBbSyBrA2CLSiijEAxRimBCC5b9rUVVFLV62KikJyH6srSB3QRGSbwXoZQ0OQxATAYgJobmEAuQVFDOiSUHQ3D1T4URFicR8A57XLGY7fFCcAAAAASUVORK5CYII=',
			'B1DA' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7QgMYAlhDGVqRxQKmMAawNjpMdUAWa2UNYG0ICAhAUQfU2xDoIILkvtCoVVFLV0VmTUNyH5o6qHlgsdAQTDFUdSC9jY4oYqFAF7OGMqKIDVT4URFicR8AoZ3LlWBqrtEAAAAASUVORK5CYII=',
			'F453' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7QkMZWllDHUIdkMQCGhimsjYwOgSgioWyAmkRFDFGV9apYDm4+0Kjli5dmpm1NAvJfQENIq0gEtU8UaCdAWjmAd2CRYzR0RHdLa0MoQwobh6o8KMixOI+AO27za5wAV1HAAAAAElFTkSuQmCC',
			'9034' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7WAMYAhhDGRoCkMREpjCGsDY6NCKLBbSytoJIVDERoCqHKQFI7ps2ddrKrKmroqKQ3MfqClLn6ICslwGktyEwNARJTABiBza3oIhhc/NAhR8VIRb3AQCwKc4m/3xCjwAAAABJRU5ErkJggg==',
			'8897' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7WAMYQxhCGUNDkMREprC2Mjo6NIggiQW0ijS6NgSgiIHUsQLFApDctzRqZdjKzKiVWUjuA6ljCAloZUAzz6EhYAq6mGNDQAADhlscHbC4GUVsoMKPihCL+wBAk8wMQrEfcwAAAABJRU5ErkJggg==',
			'1733' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7GB1EQx1DGUIdkMRYHRgaXRsdHQKQxESBYg4NAQ0iKHoZWiGiCPetzFo1bdXUVUuzkNwHVBeApA4qBhTFMI+1AVNMpIEV3S0hIg2MaG4eqPCjIsTiPgCj/crgN5ZwDQAAAABJRU5ErkJggg==',
			'8C00' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXUlEQVR4nGNYhQEaGAYTpIn7WAMYQxmmMLQii4lMYW10CGWY6oAkFtAq0uDo6BAQgKJOpIG1IdBBBMl9S6OmrVq6KjJrGpL70NTBzcMmhmkHpluwuXmgwo+KEIv7AALnzN8gR2lDAAAAAElFTkSuQmCC',
			'8C24' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7WAMYQxlCGRoCkMREprA2Ojo6NCKLBbSKNLgCSVR1IiCZKQFI7lsaNW3VqpVZUVFI7gOra2V0QDePYQpjaAiamEMAFrc4oIqB3MwaGoAiNlDhR0WIxX0AxBrONXDB9k4AAAAASUVORK5CYII=',
			'EB1C' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXElEQVR4nGNYhQEaGAYTpIn7QkNEQximMEwNQBILaBBpZQhhCBBBFWt0DGF0YEFXN4XRAdl9oVFTw1ZNW5mF7D40dXDzHHCIYdqB6haQmxlDHVDcPFDhR0WIxX0ADfXMLwBAGdMAAAAASUVORK5CYII=',
			'85AC' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7WANEQxmmMEwNQBITmSLSwBDKECCCJBbQKtLA6OjowIKqLoS1IdAB2X1Lo6YuXboqMgvZfSJTGBpdEeqg5gHFQtHFRMDqUO1gbWVtCEBxC2sAI9DeABQ3D1T4URFicR8ABtnMVm+kHfEAAAAASUVORK5CYII=',
			'8990' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7WAMYQxhCGVqRxUSmsLYyOjpMdUASC2gVaXRtCAgIQFEHEgt0EEFy39KopUszMyOzpiG5T2QKY6BDCFwd1DyGRocGdDGWRkcMOzDdgs3NAxV+VIRY3AcArUnMmKr/4/8AAAAASUVORK5CYII=',
			'1A8A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7GB0YAhhCGVqRxVgdGEMYHR2mOiCJiTqwtrI2BAQEoOgVaXR0dHQQQXLfyqxpK7NCgSSS+9DUQcVEQ10bAkND0MwDiqGpw9QrGiLS6BDKiCI2UOFHRYjFfQAGxckO2HcyYwAAAABJRU5ErkJggg==',
			'D6E5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZklEQVR4nGNYhQEaGAYTpIn7QgMYQ1hDHUMDkMQCprC2sjYwOiCrC2gVacQi1gAUc3VAcl/U0mlhS0NXRkUhuS+gVRRoHkODCJp5rljFGB1QxMBuYQhAdh/EzQ5THQZB+FERYnEfADKfzGpdT+WxAAAAAElFTkSuQmCC',
			'5C6D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7QkMYQxlCGUMdkMQCGlgbHR0dHQJQxEQaXBscHUSQxAIDRBpYGxhhYmAnhU2btmrp1JVZ05Dd1wpU54iqFyzWEIgiFtAKsgNVTGQKpltYAzDdPFDhR0WIxX0A6XvL21C4zQgAAAAASUVORK5CYII=',
			'7A1A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7QkMZAhimMLSiiLYyhjCEMEx1QBFjBYkGBCCLTRFpdJjC6CCC7L6oaSuzQAjJfUAVyOrAkLVBNBQoFhqCJCbSgKkuAIeYY6gjithAhR8VIRb3AQDxUst/ImwKpAAAAABJRU5ErkJggg==',
			'1D83' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXklEQVR4nGNYhQEaGAYTpIn7GB1EQxhCGUIdkMRYHURaGR0dHQKQxEQdRBpdGwIaRFD0ijQClTUEILlvZda0lVmhq5ZmIbkPTR1cDJt5WMQw3RKC6eaBCj8qQizuAwAj4cqkFUCK6AAAAABJRU5ErkJggg==',
			'C4E5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbElEQVR4nGNYhQEaGAYTpIn7WEMYWllDHUMDkMREWhmmsjYwOiCrC2hkCMUQa2B0BYq5OiC5L2rV0qVLQ1dGRSG5LwBoIivIXBS9oqGu6GKNQLcA7UAWA7oFpDcA2X0QNztMdRgE4UdFiMV9AE1ryuQPbLQnAAAAAElFTkSuQmCC',
			'8BFF' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAUElEQVR4nGNYhQEaGAYTpIn7WANEQ1hDA0NDkMREpoi0sjYwOiCrC2gVaXRFE0NTB3bS0qipYUtDV4ZmIbmPWPOIsAPhZjSxgQo/KkIs7gMAHjTJmR/GuDkAAAAASUVORK5CYII=',
			'52FE' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZUlEQVR4nGNYhQEaGAYTpIn7QkMYQ1hDA0MDkMQCGlhbWRsYHRhQxEQaXdHEAgMYkMXATgqbtmrp0tCVoVnI7mtlmIJuHlAsAMOOVkYHdDERoE50MdYA0VCgvShuHqjwoyLE4j4A89zJXDQlzdgAAAAASUVORK5CYII=',
			'D4BB' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7QgMYWllDGUMdkMQCpjBMZW10dAhAFmtlCGVtCHQQQRFjdEVSB3ZS1FIgCF0ZmoXkvoBWkVZM80RDXTHMA7oFXWwKA4ZebG4eqPCjIsTiPgCzws1yZoZYFgAAAABJRU5ErkJggg==',
			'1C07' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7GB0YQxmmMIaGIImxOrA2OoQyNIggiYk6iDQ4OjqgiDECxVgbAoAQ4b6VWdNWLV0VtTILyX1Qda0MmHqnoIsB7QhAFQO5hdEBWUw0BOxmFLGBCj8qQizuAwDsEslh9qftbwAAAABJRU5ErkJggg==',
			'8E19' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZUlEQVR4nGNYhQEaGAYTpIn7WANEQxmmMEx1QBITmSLSwBDCEBCAJBbQKtLAGMLoIIKubgpcDOykpVFTw1ZNWxUVhuQ+iDqGqSJo5gHFGrCIYbED1S0gNzOGOqC4eaDCj4oQi/sA7ILLVGqqzn4AAAAASUVORK5CYII=',
			'5FE0' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXElEQVR4nGNYhQEaGAYTpIn7QkNEQ11DHVqRxQIaRBpYGximOmCKBQQgiQUGgMQYHUSQ3Bc2bWrY0tCVWdOQ3deKog6nWEArph0iUzDdwgqyF83NAxV+VIRY3AcArD3LnyAdnPoAAAAASUVORK5CYII=',
			'58BF' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAX0lEQVR4nGNYhQEaGAYTpIn7QkMYQ1hDGUNDkMQCGlhbWRsdHRhQxEQaXRsCUcQCA1DUgZ0UNm1l2NLQlaFZyO5rxTSPoRXTvAAsYiJTMPWyBoDdjGreAIUfFSEW9wEAkRjKrMVRUTkAAAAASUVORK5CYII=',
			'74FE' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXElEQVR4nGNYhQEaGAYTpIn7QkMZWllDA0MDkEVbGaayNjA6MKCKhWKITWF0RRKDuClq6dKloStDs5Dcx+gg0oqul7VBNNQVTUwEaAu6ugDcYqhuHqDwoyLE4j4AqbDIqdIkr8AAAAAASUVORK5CYII=',
			'DBC0' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAW0lEQVR4nGNYhQEaGAYTpIn7QgNEQxhCHVqRxQKmiLQyOgRMdUAWaxVpdG0QCAhAFWtlbWB0EEFyX9TSqWFLV63MmobkPjR1SOZhE0OzA4tbsLl5oMKPihCL+wCLfM4V59lBWAAAAABJRU5ErkJggg==',
			'5690' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7QkMYQxhCGVqRxQIaWFsZHR2mOqCIiTSyNgQEBCCJBQaINLA2BDqIILkvbNq0sJWZkVnTkN3XKtrKEAJXBxUTaXRoQBULAIo5otkhMgXTLawBmG4eqPCjIsTiPgAXrcwPnwQt/QAAAABJRU5ErkJggg==',
			'2844' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcklEQVR4nGNYhQEaGAYTpIn7WAMYQxgaHRoCkMREprC2MrQ6NCKLBbSKNDpMdWhFFmNoBaoLdJgSgOy+aSvDVmZmRUUhuy+AtZW10dEBWS+jg0ija2hgaAiyWxqAdqC7pQFoB5pYaCimmwcq/KgIsbgPANPkzlq8dhTTAAAAAElFTkSuQmCC',
			'9BD7' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7WANEQ1hDGUNDkMREpoi0sjY6NIggiQW0ijS6NgSgi7WyAsUCkNw3berUsKWrolZmIbmP1RWsrhXFZoh5U5DFBCBiAQwYbnF0wOJmFLGBCj8qQizuAwBTLMzQUYh5fgAAAABJRU5ErkJggg==',
			'1956' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAc0lEQVR4nGNYhQEaGAYTpIn7GB0YQ1hDHaY6IImxOrC2sjYwBAQgiYk6iDS6AlULoOgFik1ldEB238qspUtTMzNTs5DcB7Qj0KEhEMU8oK5GoJiDCIoYC9AOdDHWVkZHB1S3hDCGMIQyoLh5oMKPihCL+wAplckIckyArQAAAABJRU5ErkJggg==',
			'312F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7RAMYAhhCGUNDkMQCpjAGMDo6OqCobGUNYG0IRBWbAtSLEAM7aWXUqqhVKzNDs5DdB1LXyohmHlBsChaxAFSxgCkgEVQx0QDWUNZQNLcMUPhREWJxHwBI0cZ4QRXpTQAAAABJRU5ErkJggg==',
			'1B57' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7GB1EQ1hDHUNDkMRYHURaWYG0CJKYqINIoyuaGCNI3VSGhgAk963Mmhq2NDNrZRaS+0DqgKpaUe0VaXRoCJiCLubaEBCAJtbK6OjogCwmGiIawhDKiCI2UOFHRYjFfQCdLMkpwqRhygAAAABJRU5ErkJggg==',
			'3F8A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAY0lEQVR4nGNYhQEaGAYTpIn7RANEQx1CGVqRxQKmiDQwOjpMdUBW2SrSwNoQEBCALAZW5+ggguS+lVFTw1aFrsyahuw+VHVI5gWGhmCKoagLwKJXNADIC2VENW+Awo+KEIv7ANjByvJF8yqUAAAAAElFTkSuQmCC',
			'2F1B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7WANEQx2mMIY6IImJTBFpYAhhdAhAEgtoFWlgBIqJIOsGijFMgauDuGna1LBV01aGZiG7LwBFHRiCTZqCah5rA6aYSAOm3tBQoFtCHVHcPFDhR0WIxX0AqyjKOe7qVYYAAAAASUVORK5CYII=',
			'BF28' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7QgNEQx1CGaY6IIkFTBFpYHR0CAhAFmsVaWBtCHQQQVMHJGHqwE4KjZoatmpl1tQsJPeB1bUyYJjHMIUR1TyQWAAjhh2MDqh6QwOAbgkNQHHzQIUfFSEW9wEAofTNPekmZDgAAAAASUVORK5CYII=',
			'653E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7WANEQxmBMABJTGSKSANro6MDsrqAFhEgGYgq1iASwoBQB3ZSZNTUpaumrgzNQnJfyBSGRgd081qBYujmtYpgiIlMYW1FdwtrAGMIupsHKvyoCLG4DwA8iMt8ee1WMQAAAABJRU5ErkJggg==',
			'D290' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7QgMYQxhCGVqRxQKmsLYyOjpMdUAWaxVpdG0ICAhAEWMAigU6iCC5L2rpqqUrMyOzpiG5D6huCkMIXB1MLIChAV2M0YER3Y4prA3obgkNEA11QHPzQIUfFSEW9wEAAR3NmC9aoQMAAAAASUVORK5CYII=',
			'9101' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZklEQVR4nGNYhQEaGAYTpIn7WAMYAhimMLQii4lMYQxgCGWYiiwW0MoawOjoEIoqxhDACiKR3Ddt6qqopSCE5D5WVxR1ENiKKSYAFAPageYWBpBbUMRYA1hDgW4ODRgE4UdFiMV9AKrQyVxbHuhVAAAAAElFTkSuQmCC',
			'806B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7WAMYAhhCGUMdkMREpjCGMDo6OgQgiQW0srayNjg6iKCoE2l0bWCEqQM7aWnUtJWpU1eGZiG5D6wOwzyQ3kAU8yB2BKLZgekWbG4eqPCjIsTiPgDUpcsoCI+IcwAAAABJRU5ErkJggg==',
			'D96F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAX0lEQVR4nGNYhQEaGAYTpIn7QgMYQxhCGUNDkMQCprC2Mjo6OiCrC2gVaXRtwCbGCBMDOylq6dKlqVNXhmYhuS+glTHQFcM8BqDeQDQxFkwxLG6BuhlFbKDCj4oQi/sAiibLiyTy3UIAAAAASUVORK5CYII='        
        );
        $this->text = array_rand( $images );
        return $images[ $this->text ] ;    
    }
    
    function out_processing_gif(){
        $image = dirname(__FILE__) . '/processing.gif';
        $base64_image = "R0lGODlhFAAUALMIAPh2AP+TMsZiALlcAKNOAOp4ANVqAP+PFv///wAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFCgAIACwAAAAAFAAUAAAEUxDJSau9iBDMtebTMEjehgTBJYqkiaLWOlZvGs8WDO6UIPCHw8TnAwWDEuKPcxQml0Ynj2cwYACAS7VqwWItWyuiUJB4s2AxmWxGg9bl6YQtl0cAACH5BAUKAAgALAEAAQASABIAAAROEMkpx6A4W5upENUmEQT2feFIltMJYivbvhnZ3Z1h4FMQIDodz+cL7nDEn5CH8DGZhcLtcMBEoxkqlXKVIgAAibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkphaA4W5upMdUmDQP2feFIltMJYivbvhnZ3V1R4BNBIDodz+cL7nDEn5CH8DGZAMAtEMBEoxkqlXKVIg4HibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpjaE4W5tpKdUmCQL2feFIltMJYivbvhnZ3R0A4NMwIDodz+cL7nDEn5CH8DGZh8ONQMBEoxkqlXKVIgIBibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpS6E4W5spANUmGQb2feFIltMJYivbvhnZ3d1x4JMgIDodz+cL7nDEn5CH8DGZgcBtMMBEoxkqlXKVIggEibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpAaA4W5vpOdUmFQX2feFIltMJYivbvhnZ3V0Q4JNhIDodz+cL7nDEn5CH8DGZBMJNIMBEoxkqlXKVIgYDibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpz6E4W5tpCNUmAQD2feFIltMJYivbvhnZ3R1B4FNRIDodz+cL7nDEn5CH8DGZg8HNYMBEoxkqlXKVIgQCibbK9YLBYvLtHH5K0J0IACH5BAkKAAgALAEAAQASABIAAAROEMkpQ6A4W5spIdUmHQf2feFIltMJYivbvhnZ3d0w4BMAIDodz+cL7nDEn5CH8DGZAsGtUMBEoxkqlXKVIgwGibbK9YLBYvLtHH5K0J0IADs=";
        $binary = is_file($image) ? join("",file($image)) : base64_decode($base64_image); 
        header("Cache-Control: post-check=0, pre-check=0, max-age=0, no-store, no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: image/gif");
        echo $binary;
    }

}
# end of class phpfmgImage
# ------------------------------------------------------
# end of module : captcha


# module user
# ------------------------------------------------------
function phpfmg_user_isLogin(){
    return ( isset($_SESSION['authenticated']) && true === $_SESSION['authenticated'] );
}


function phpfmg_user_logout(){
    session_destroy();
    header("Location: admin.php");
}

function phpfmg_user_login()
{
    if( phpfmg_user_isLogin() ){
        return true ;
    };
    
    $sErr = "" ;
    if( 'Y' == $_POST['formmail_submit'] ){
        if(
            defined( 'PHPFMG_USER' ) && strtolower(PHPFMG_USER) == strtolower($_POST['Username']) &&
            defined( 'PHPFMG_PW' )   && strtolower(PHPFMG_PW) == strtolower($_POST['Password']) 
        ){
             $_SESSION['authenticated'] = true ;
             return true ;
             
        }else{
            $sErr = 'Login failed. Please try again.';
        }
    };
    
    // show login form 
    phpfmg_admin_header();
?>
<form name="frmFormMail" action="" method='post' enctype='multipart/form-data'>
<input type='hidden' name='formmail_submit' value='Y'>
<br><br><br>

<center>
<div style="width:380px;height:260px;">
<fieldset style="padding:18px;" >
<table cellspacing='3' cellpadding='3' border='0' >
	<tr>
		<td class="form_field" valign='top' align='right'>Email :</td>
		<td class="form_text">
            <input type="text" name="Username"  value="<?php echo $_POST['Username']; ?>" class='text_box' >
		</td>
	</tr>

	<tr>
		<td class="form_field" valign='top' align='right'>Password :</td>
		<td class="form_text">
            <input type="password" name="Password"  value="" class='text_box'>
		</td>
	</tr>

	<tr><td colspan=3 align='center'>
        <input type='submit' value='Login'><br><br>
        <?php if( $sErr ) echo "<span style='color:red;font-weight:bold;'>{$sErr}</span><br><br>\n"; ?>
        <a href="admin.php?mod=mail&func=request_password">I forgot my password</a>   
    </td></tr>
</table>
</fieldset>
</div>
<script type="text/javascript">
    document.frmFormMail.Username.focus();
</script>
</form>
<?php
    phpfmg_admin_footer();
}


function phpfmg_mail_request_password(){
    $sErr = '';
    if( $_POST['formmail_submit'] == 'Y' ){
        if( strtoupper(trim($_POST['Username'])) == strtoupper(trim(PHPFMG_USER)) ){
            phpfmg_mail_password();
            exit;
        }else{
            $sErr = "Failed to verify your email.";
        };
    };
    
    $n1 = strpos(PHPFMG_USER,'@');
    $n2 = strrpos(PHPFMG_USER,'.');
    $email = substr(PHPFMG_USER,0,1) . str_repeat('*',$n1-1) . 
            '@' . substr(PHPFMG_USER,$n1+1,1) . str_repeat('*',$n2-$n1-2) . 
            '.' . substr(PHPFMG_USER,$n2+1,1) . str_repeat('*',strlen(PHPFMG_USER)-$n2-2) ;


    phpfmg_admin_header("Request Password of Email Form Admin Panel");
?>
<form name="frmRequestPassword" action="admin.php?mod=mail&func=request_password" method='post' enctype='multipart/form-data'>
<input type='hidden' name='formmail_submit' value='Y'>
<br><br><br>

<center>
<div style="width:580px;height:260px;text-align:left;">
<fieldset style="padding:18px;" >
<legend>Request Password</legend>
Enter Email Address <b><?php echo strtoupper($email) ;?></b>:<br />
<input type="text" name="Username"  value="<?php echo $_POST['Username']; ?>" style="width:380px;">
<input type='submit' value='Verify'><br>
The password will be sent to this email address. 
<?php if( $sErr ) echo "<br /><br /><span style='color:red;font-weight:bold;'>{$sErr}</span><br><br>\n"; ?>
</fieldset>
</div>
<script type="text/javascript">
    document.frmRequestPassword.Username.focus();
</script>
</form>
<?php
    phpfmg_admin_footer();    
}


function phpfmg_mail_password(){
    phpfmg_admin_header();
    if( defined( 'PHPFMG_USER' ) && defined( 'PHPFMG_PW' ) ){
        $body = "Here is the password for your form admin panel:\n\nUsername: " . PHPFMG_USER . "\nPassword: " . PHPFMG_PW . "\n\n" ;
        if( 'html' == PHPFMG_MAIL_TYPE )
            $body = nl2br($body);
        mailAttachments( PHPFMG_USER, "Password for Your Form Admin Panel", $body, PHPFMG_USER, 'You', "You <" . PHPFMG_USER . ">" );
        echo "<center>Your password has been sent.<br><br><a href='admin.php'>Click here to login again</a></center>";
    };   
    phpfmg_admin_footer();
}


function phpfmg_writable_check(){
 
    if( is_writable( dirname(PHPFMG_SAVE_FILE) ) && is_writable( dirname(PHPFMG_EMAILS_LOGFILE) )  ){
        return ;
    };
?>
<style type="text/css">
    .fmg_warning{
        background-color: #F4F6E5;
        border: 1px dashed #ff0000;
        padding: 16px;
        color : black;
        margin: 10px;
        line-height: 180%;
        width:80%;
    }
    
    .fmg_warning_title{
        font-weight: bold;
    }

</style>
<br><br>
<div class="fmg_warning">
    <div class="fmg_warning_title">Your form data or email traffic log is NOT saving.</div>
    The form data (<?php echo PHPFMG_SAVE_FILE ?>) and email traffic log (<?php echo PHPFMG_EMAILS_LOGFILE?>) will be created automatically when the form is submitted. 
    However, the script doesn't have writable permission to create those files. In order to save your valuable information, please set the directory to writable.
     If you don't know how to do it, please ask for help from your web Administrator or Technical Support of your hosting company.   
</div>
<br><br>
<?php
}


function phpfmg_log_view(){
    $n = isset($_REQUEST['file'])  ? $_REQUEST['file']  : '';
    $files = array(
        1 => PHPFMG_EMAILS_LOGFILE,
        2 => PHPFMG_SAVE_FILE,
    );
    
    phpfmg_admin_header();
   
    $file = $files[$n];
    if( is_file($file) ){
        if( 1== $n ){
            echo "<pre>\n";
            echo join("",file($file) );
            echo "</pre>\n";
        }else{
            $man = new phpfmgDataManager();
            $man->displayRecords();
        };
     

    }else{
        echo "<b>No form data found.</b>";
    };
    phpfmg_admin_footer();
}


function phpfmg_log_download(){
    $n = isset($_REQUEST['file'])  ? $_REQUEST['file']  : '';
    $files = array(
        1 => PHPFMG_EMAILS_LOGFILE,
        2 => PHPFMG_SAVE_FILE,
    );

    $file = $files[$n];
    if( is_file($file) ){
        phpfmg_util_download( $file, PHPFMG_SAVE_FILE == $file ? 'form-data.csv' : 'email-traffics.txt', true, 1 ); // skip the first line
    }else{
        phpfmg_admin_header();
        echo "<b>No email traffic log found.</b>";
        phpfmg_admin_footer();
    };

}


function phpfmg_log_delete(){
    $n = isset($_REQUEST['file'])  ? $_REQUEST['file']  : '';
    $files = array(
        1 => PHPFMG_EMAILS_LOGFILE,
        2 => PHPFMG_SAVE_FILE,
    );
    phpfmg_admin_header();

    $file = $files[$n];
    if( is_file($file) ){
        echo unlink($file) ? "It has been deleted!" : "Failed to delete!" ;
    };
    phpfmg_admin_footer();
}


function phpfmg_util_download($file, $filename='', $toCSV = false, $skipN = 0 ){
    if (!is_file($file)) return false ;

    set_time_limit(0);


    $buffer = "";
    $i = 0 ;
    $fp = @fopen($file, 'rb');
    while( !feof($fp)) { 
        $i ++ ;
        $line = fgets($fp);
        if($i > $skipN){ // skip lines
            if( $toCSV ){ 
              $line = str_replace( chr(0x09), ',', $line );
              $buffer .= phpfmg_data2record( $line, false );
            }else{
                $buffer .= $line;
            };
        }; 
    }; 
    fclose ($fp);
  

    
    /*
        If the Content-Length is NOT THE SAME SIZE as the real conent output, Windows+IIS might be hung!!
    */
    $len = strlen($buffer);
    $filename = basename( '' == $filename ? $file : $filename );
    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    switch( $file_extension ) {
        case "pdf": $ctype="application/pdf"; break;
        case "exe": $ctype="application/octet-stream"; break;
        case "zip": $ctype="application/zip"; break;
        case "doc": $ctype="application/msword"; break;
        case "xls": $ctype="application/vnd.ms-excel"; break;
        case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpg"; break;
        case "mp3": $ctype="audio/mpeg"; break;
        case "wav": $ctype="audio/x-wav"; break;
        case "mpeg":
        case "mpg":
        case "mpe": $ctype="video/mpeg"; break;
        case "mov": $ctype="video/quicktime"; break;
        case "avi": $ctype="video/x-msvideo"; break;
        //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
        case "php":
        case "htm":
        case "html": 
                $ctype="text/plain"; break;
        default: 
            $ctype="application/x-download";
    }
                                            

    //Begin writing headers
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
    //Use the switch-generated Content-Type
    header("Content-Type: $ctype");
    //Force the download
    header("Content-Disposition: attachment; filename=".$filename.";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$len);
    
    while (@ob_end_clean()); // no output buffering !
    flush();
    echo $buffer ;
    
    return true;
 
    
}
?>