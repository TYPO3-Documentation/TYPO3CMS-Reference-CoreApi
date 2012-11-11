.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt
.. include:: Images.txt


Parsing HTML: t3lib\_parsehtml
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This class is very handy for various processing needs of HTML. In the
future it might be obsolete if the "tidy" extension becomes standard
in PHP but for now there are no native features in PHP which lets us
parse HTML.


Extracting blocks from an HTML document
"""""""""""""""""""""""""""""""""""""""

In the first example it is shown how we can extract parts of an HTML
document. ::

      1: require_once(PATH_t3lib . 'class.t3lib_parsehtml.php');
      2:
      3: $testHTML = '
      4:     <DIV>
      5:         <IMG src="welcome.gif">
      6:         <p>Line 1</p>
      7:         <p>Line <B class="test">2</B></p>
      8:         <p>Line <b><i>3</i></p>
      9:         <img src="test.gif" />
     10:         <BR><br/>
     11:         <TABLE>
     12:             <tr>
     13:                 <td>Another line here</td>
     14:             </tr>
     15:         </TABLE>
     16:     </div>
     17:     <B>Text outside div tag</B>
     18:     <table>
     19:         <tr>
     20:             <td>Another line here</td>
     21:         </tr>
     22:     </table>
     23: ';
     24:
     25:     // Splitting HTML into blocks defined by <div> and <table> tags
     26: $parseObj = t3lib_div::makeInstance('t3lib_parsehtml');
     27: $result = $parseObj->splitIntoBlock('div,table', $testHTML);
     28: debug($result, 'Splitting by <div> and <table> tags');
     29:

- Line 1 includes the library.

- Line 3-23 loads the HTML sample code into a variable.

- Line 36 creates an instance of the parser-class.Notice how
  t3lib\_div::makeInstance() is used (required).

- Line 27 splits the HTML content into an array dividing it by <div> or
  <table> tags.

- Line 28 outputs the result array with the debug() function:

|img-28| As you can see the HTML source has been divided so the <div>
section and the <table> is found in key 1 and 3. The keys of the
extracted content is always the odd keys while the even keys are the
"outside" content.

Notice that the table  *inside* of the <div> section was not "found".
So when you split content like this you get only elements on the same
block-level in the source. You have to traverse the content
recursively to find all tables - or just split on <table> only (which
will not give you tables nested inside of tables though).


Extracting single tags
""""""""""""""""""""""

You can split the content by tag as well. This is done in the next
example. Here all <img> and <br> tags are found::

     30:     // Splitting HTML into blocks defined by <img> and <br> tags
     31: $result = $parseObj->splitTags('img,br', $testHTML);
     32: debug($result,'Extracting <img> and <br> tags');
     33:

Line 31 performs the splitting operation. This is the output:

|img-29| Again, all the odd keys in the array contains the tags that
were found. If you wanted to do processing on this content you just
traverse the array, process all odd keys and implode the array again.
A code listing for that might look like this::

   foreach($result as $intKey => $HTMLvalue)    {
           // Find all ODD keys:
       if ($intKey%2)    {
           $result[$intKey] = '--'.$result[$intKey].'--';
       }
   }
   $newContent = implode('',$result);


Cleaning HTML content
"""""""""""""""""""""

You can also do processing on the HTML content by the HTMLcleaner()
method. This code listings shows a basic example of how you can
configure it. There are a lot of features hidden in the $tagCfg array
and you should refer to the inline documentation of the method in the
class. ::

     34:     // Cleaning HTML:
     35: $tagCfg = array_flip(explode(',', 'b,img,div,br,p'));
     36: $tagCfg['b'] = array(
     37:     'nesting' => 1,
     38:     'remap' => 'strong',
     39:     'allowedAttribs' => 0
     40: );
     41: $tagCfg['p'] = array(
     42:     'fixAttrib' => array(
     43:         'class' => array(
     44:             'set' => 'bodytext'
     45:         )
     46:     )
     47: );
     48: $result = $parseObj->HTMLcleaner($testHTML, $tagCfg, FALSE, FALSE, array('xhtml' => 1));
     49: debug(array($result), 'Cleaning to XHTML, removing non-allowed tags and attributes');

- Line 35 initializes the $tagCfg array by setting the five allowed tags
  as keys. Only these tag names are allowed! All others are removed
  (HTMLcleaner() can be configured to keep all unknown tags though).

- Line 36-40 configures additional options for the "b" tag. First of all
  correct nesting is required. This means that the single <b> tag in one
  of the paragraphs will be removed. Then the "remap" key is set which
  means that all occurencies of <b> tags will be substituted with
  <strong> tags instead. Finally the allowed attributes are set to false
  which means that any attributes set for <b> tags are removed.

- Line 41-47 configures additional options for the "p" tag. In this case
  it just hardcodes that the attribute "class" must exist and it must
  have the value "bodytext".

- Line 48 calls the HTMLcleaner() method - and notice the extra options
  being set where "xhtml" cleaning is enabled. This will convert all tag
  an attribute names to lowercase and "close" tags like <img> and <br>
  to <img.../> and <br />

This is the output:


|img-30| Advanced call back processing
""""""""""""""""""""""""""""""""""""""

This code listing shows how you can register call back functions for
recursive processing of an HTML source::

      1: class user_processing {
      2:     function process($str) {
      3:         $this->parseObj = t3lib_div::makeInstance('t3lib_parsehtml_proc');
      4:
      5:         $outStr = $this->parseObj->splitIntoBlockRecursiveProc(
      6:             'div|table|blockquote|caption|tr|td|th|h1|h2|h3|h4|h5|h6|ol|ul',
      7:             $str,
      8:             $this,
      9:             'callBackContent',
     10:             'callBackTags'
     11:         );
     12:
     13:         return $outStr;
     14:     }
     15:
     16:     function callBackContent($str, $level) {
     17:         if (trim($str)) {
     18:
     19:                 // Fixing <P>
     20:             $pSections = $this->parseObj->splitTags('p', $str);
     21:             foreach($pSections as $k => $v)    {
     22:                 $pSections[$k] = trim(ereg_replace('[[:space:]]+', ' ', $pSections[$k]));
     23:                 if (!($k%2)) {
     24:
     25:                     if ($k && !strstr(strtolower($pSections[$k]), '</p>')) {
     26:                         $pSections[$k] = trim($pSections[$k]) . '</p>';
     27:                     }
     28:
     29:                     $pSections[$k].=chr(10);
     30:                 }
     31:             }
     32:             $str = implode('',$pSections);
     33:         }
     34:
     35:         if (trim($str)) {
     36:             $str = $this->parseObj->indentLines(trim($str),$level) . chr(10);
     37:         } else {
     38:             $str = trim($str);
     39:         }
     40:
     41:         return $str;
     42:     }
     43:
     44:     function callBackTags($tags,$level) {
     45:
     46:         if (substr($tags['tag_name'],0,1) == 'h') {
     47:             $tags['tag_end'] .= chr(10);
     48:             $tags['content'] = trim($tags['content']);
     49:                 // Removing the <hx> tags if they content nothing when tags are stripped:
     50:             if (!strlen(trim(strip_tags($tags['content'])))) {
     51:                 $tags['tag_start'] = $tags['tag_end'] = '';
     52:                 $tags['add_level'] = 0;
     53:                 $tags['content'] = '';
     54:                 return $tags;
     55:             }
     56:         } elseif ($tags['tag_name'] == 'div' || $tags['tag_name'] == 'blockquote') {
     57:             $tags['tag_start'] = $tags['tag_end'] = '';
     58:             $tags['add_level'] = 0;
     59:         } else {
     60:             $tags['tag_start'] = $this->parseObj->indentLines(trim($tags['tag_start']),$level) . chr(10);
     61:             $tags['tag_end'] = $this->parseObj->indentLines(trim($tags['tag_end']),$level) . chr(10);
     62:         }
     63:         return $tags;
     64:     }
     65: }

In the method "process()" processing is started. Like when splitting
HTML content you define a list of tags to split by. Each of these will
be processed by the call back functions "callBackContent" and
"callBackTags" for processing of both the content between the splitted
tags and the tags themselves.

Notice how it is all within the same class which is a requirement for
the call back functions.

I'll not explain this listing in further detail. Explore it yourself
if you are interested in call back processing of HTML sources.


