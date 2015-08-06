@desc read host file and create a html clickable page from it
@tags etc/hosts , hosts

<?php
/**
 * @file
 *
 * Generate html links for domains from an hosts file. (e.g /etc/hosts)
 * You must add "tags" in comments in your Hosts file to let choose
 * which hosts have to be converted to link in the rendered html.
 *
 *
 * Example :
 *
 *  #GenerateHtml
 *
 *  # FRANCE24 LOCAL
 *  127.0.0.1	www.france24.local/fr
 *  127.0.0.1	www.france24.local/en
 *  127.0.0.1	www.france24.local/ar
 *  127.0.0.1	iphone.france24.local
 *  127.0.0.1	mobile.france24.local
 *  127.0.0.1	feeds.france24.local
 *
 *  # RFI LOCAL
 *  127.0.0.1	www.rfi.local
 *  127.0.0.1	www.persian.rfi.local
 *  127.0.0.1	www.english.rfi.local
 *  127.0.0.1	www.chinese.rfi.local
 *  127.0.0.1	www.hausa.rfi.local
 *  127.0.0.1	www.intranet.rfi.local
 *  127.0.0.1	mobile.english.rfi.local
 *
 *  # RFIMUSIQUE LOCAL
 *  127.0.0.1	www.rfimusique.local
 *  127.0.0.1	www.rfimusic.local
 *
 *  #EndGenerateHtml
 */

// CONFIG
define('HOST_FILE_PATH', '/etc/hosts');
define('BEGIN_TAG', 'GenerateHtml');
define('END_TAG', 'EndGenerateHtml');

print '<style type="text/css">
  ul{list-style-type : none; padding : 0; margin : 0;}
  table{margin:auto; border : solid gray 1px; border-collapse : collapse;text-align : center;}
  table td{border : solid silver 1px; text-align : center; padding : 3px}
  table td.comment{background : rgb(235,234,236);}
</style>';

$file = new HostsFile(HOST_FILE_PATH);
$host2html  = new HostsFiletoHtml($file);
print $host2html->theme($host2html->lines);



class HostsFiletoHtml {

  // an HostsFile object
  public $file = NULL;
  public $tagBegin = BEGIN_TAG;
  public $tagEnd = END_TAG;
  // array of line object we want to generate an interface for
  public $lines = array();

  function __construct(HostsFile $file) {
    $this->file = $file;
    $this->lines = $this->findLinesGroup();
  }

  // make some html links with domains names
  // @return array
  function domainsToLinks($domains = array()) {
    $links = array();
    foreach ($domains as $domain) {
      $links[] = '<a target="_blank" href="http://' . $domain . '">' . $domain . '</a>';
    }
    return $links;
  }

  // Find lines delimited by our begin/end tag.
  // @return array
  function findLinesGroup() {
    $lines = array();
    $record = FALSE;
    foreach ($this->file->lines as $line) {
      if ($record && trim($line->raw_line) != '') {
        $lines[] = $line;
      }
      //if we find ou begin tag, record following lines in a variable
      if (strpos($line->raw_line, $this->tagBegin)) {
        $record = TRUE;
      }
      // if end tag found, stop recording lines
      if (strpos($line->raw_line, $this->tagEnd)) {
        $record = FALSE;
        array_pop($lines);
      }
    }

    return $lines;
  }


  // render html for our lines
  // @return string
  function theme($lines) {
    $out = '<table>';
    $out .= '</tr>';
    foreach ($lines as $line) {
      $out .= '<tr>';
      if ($line->isComment()) {
        $out .= '<td class="comment" colspan=3><strong>' . str_replace('#', '', $line->raw_line) . '</strong></td>';
      }
      else {
        $out .= '<td>' . $line->number . '</td>';
        $out .= '<td>' . $line->ip . '</td>';
        $out .= '<td>';
        $out .= '<ul>';
        foreach ($this->domainsToLinks($line->domains) as $domain) {
          $out .= '<li>';
          $out .= $domain;
          $out .= '</li>';
        }
        $out .= '</ul>';
        $out .= '</td>';
      }
      $out .= '</tr>';
    }
    $out .= '</table>';
    return $out;
  }

}

/**
 * Represents a host file as an object containing line as objects
 */
class HostsFile {

  // path to hostfile
  public $path = HOST_FILE_PATH;

  // contains lines as HostFileLine object
  protected $line = array();

  function __construct($path) {
    $this->path = $path;
    $this->buildRepresentation();
  }

  // create representation in an objet way from an host file
  function buildRepresentation() {
    $raw_lines = explode("\n", file_get_contents($this->path));
    foreach ($raw_lines as $number => $raw_line) {
      $this->lines[] = new HostsFileLine($raw_line, $number);
    }
  }

}

/**
 * Represents a line of an hostFile
 */
class HostsFileline{

  // the raw line as text.
  public $raw_line = '';

  // ip déclarée par la ligne
  public $ip = NULL;

  // numero de ligne
  public $number;

  // domain(s) declared in this line
  public $domains = array();

  function __construct($raw_line, $number) {
    $this->raw_line = $raw_line;
    if (!$this->isComment()) {
      $this->ip  = $this->getIp();
      $this->domains = $this->getDomains();
      $this->number = ++$number;
    }
  }

  // check if line is correctly formated
  function lineIsValid(){}

  // is this line a comment ?
  function isComment() {
    return (strpos(trim($this->raw_line), '#') === 0) ? TRUE : FALSE;
  }

  // get host ip.
  function getIp() {
    $line = preg_split('/[\s]+/', $this->raw_line);
    return trim($line[0]);
  }

  // get domainS associated to an IP on this line.
  function getDomains() {
    $fragments = preg_split('/[\s]+/', $this->raw_line);
    array_shift($fragments);
    return $fragments;
  }

}

