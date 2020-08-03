<?php
/**
 * Xaraya HTML Module
 *
 * @package modules
 * @copyright (C) 2002-2005 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage Xarigami HTML Module
 * @copyright (C) 2007-2010 2skies.com
 * @link http://xarigami.com/project/xarigami_html
 * @author HTML Module development Team
 */

/**
 * Create a new HTML tag
 *
 * @public
 * @author Richard Cave
 * @param $args['tagtype'] type of tag to create
 * @return int html ID on success, false on failure
 * @throws BAD_PARAM
 */
function html_adminapi_createtype($args)
{
    // Get arguments from argument array
    extract($args);

    // Argument check - make sure that all required arguments are present,
    // if not then set an appropriate error message and return
    $invalid = array();
    if (!isset($tagtype) || !is_string($tagtype)) {
        $invalid[] = 'tagtype';
    }
    if (count($invalid) > 0) {
        $msg = xarML('Invalid Parameter #(1) for #(2) function #(3)() in module #(4)',
                     join(', ',$invalid), 'adminapi', 'createtype', 'html');
        throw new BadParameterException(null,$msg);
    }

    // Security Check
    if(!xarSecurityCheck('AddHTML')) return;

    // Trim input
    $tagtype = trim($tagtype);
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    $htmltypestable = $xartable['htmltypes'];
    // Make sure $type is lowercase
    $tagtype = strtolower($tagtype);
    // Check for existence of tag type
    $query = "SELECT xar_id
              FROM $htmltypestable
              WHERE xar_type = ?";
    $result = $dbconn->Execute($query,array($tagtype));
    if (!$result) return false;

    if ($result->RecordCount() > 0) {
        $msg = xarML('Tag type `#(1)` already exists!', $tagtype );
        throw new DuplicateException(null,$msg);
    }

    // Get next ID in table
    $nextId = $dbconn->GenId($htmltypestable);
    // Add item
    $query = "INSERT INTO $htmltypestable (
              xar_id,
              xar_type)
            VALUES (
                    ?,
                    ?)";

    $result = $dbconn->Execute($query,array($nextId, $tagtype));
    if (!$result) return;
    // Get the ID of the item that we inserted
    $id = $dbconn->PO_Insert_ID($htmltypestable, 'xar_id');
    // Let any hooks know that we have created a new tag type
    xarModCallHooks('item', 'createtype', $id, 'id');
    // Return the id of the newly created tag to the calling process
    return $id;
}
?>