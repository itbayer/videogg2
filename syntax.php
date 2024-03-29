<?php
/**
 * Plugin videogg2 (orig. Videogg): Show Theora video from url.
 *
 * @license    GPL v3 (http://www.gnu.org/licenses/gpl.html)
 * @author     Stefan Blechschmidt, Orig.: Ludovic Kiefer
 *
 * Based on the Dailymotion plugin written by Christophe Benz,
 * which is based on the Youtube plugin written by Ikuo Obataya.
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_videogg2 extends DokuWiki_Syntax_Plugin {

  function getInfo(){
    return array(
      'author' => 'Stefan Blechschmidt (Original von Ludovic Kiefer)',
      'email'  => 'sb@it-bayer.de',
      'date'   => '2013-03-13 (2010-03-04)',
      'name'   => 'OGG Video Plugin 2',
      'desc'   => 'Show Ogg Theora videos, using the html5 video tag. Original: http://www.dokuwiki.org/plugin:videogg',
      'url'    => 'https://github.com/itbayer/videogg2/archive/master.zip',
    );
  }

  function getType() { return 'substition'; }
    function getSort() { return 159; }

    function connectTo($mode) { $this->Lexer->addSpecialPattern('\{\{videogg2>[^}]*\}\}', $mode, 'plugin_videogg2'); }

    /** URL der DokuWiki Installation ermitteln
     */
    function base_url(){
      $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
      return $protocol . '://' . $_SERVER['SERVER_NAME'] . '/_media';
    }

  /**
   * Handle the match
   */
  function handle($match, $state, $pos, &$handler){
    $params = substr($match, strlen('{{videogg2>'), - strlen('}}') ); // Strip markup
    return array($state, explode('|', $params));
  }	

  /**
   * Create output
   */
  function render($mode, &$renderer, $data) {
    if($mode == 'xhtml'){
      list($state, $params) = $data;
      list($video_url, $video_size, $intern) = $params;

      // Wenn intern gesetzt :: URL aus DokuWiki NS Kennzeichnung zusammenbauen
      if ($intern) {
        $link = array();
        $link = explode(':',$video_url);
        $link_intern = $this->base_url(); 
        foreach($link as $a) {
          if(!empty($a)) 
            $link_intern .= "/".$a;

        }
        $video_url = $link_intern;
      }

      if(substr($video_url,-3) != 'ogg' && substr($video_url,-3) != 'ogv') {
        $renderer->doc .= '<span style="color:red;">FEHLER: Es werden nur Videos mit der Endung .ogg bzw. .ogv unterst&uuml;tzt<br/>'.$video_url.'</span>';
        return false;
      }

      if(is_null($video_size) or ! substr_count  ( $video_size  , 'x')) {
        $width  = 200;
        $height = 166;
      }
      else{
        $obj_dimensions = explode('x' , $video_size);
        $width          = $obj_dimensions[0];
        $height         = $obj_dimensions[1];
      }



      $obj  = '<div id="videogg2">';
      $obj .= '<video src="'. $video_url .'" width="'. $width .'" height="'. $height .'" controls></video><br/>'; 
      $obj .= '<a href="'. $video_url .'"><small>Video Download</small></a>';      
      $obj .= '</div>';

      $renderer->doc .= $obj;

      return true;
    }
    return false;
  }
}
?>
