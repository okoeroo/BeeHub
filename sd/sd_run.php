<?php

/*·************************************************************************
 * Copyright ©2007-2011 Pieter van Beek, Almere, The Netherlands
 * 		    <http://purl.org/net/6086052759deb18f4c0c9fb2c3d3e83e>
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at <http://www.apache.org/licenses/LICENSE-2.0>
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * $Id: sd.php 3364 2011-08-04 14:11:03Z pieterb $
 **************************************************************************/

/**
 * File documentation (who cares)
 * @package SD
 */

require_once dirname(__FILE__) . '/sd.php';

SD::handle_method_spoofing();
DAV::$REGISTRY = SD_Registry::inst();
DAV::$LOCKPROVIDER = SD_Lock_Provider::inst();
DAV::$ACLPROVIDER = SD_ACL_Provider::inst();
if (isset($_SERVER['PHP_AUTH_USER'])) {
  SD_ACL_Provider::inst()->CURRENT_USER_PRINCIPAL = DAV::parseURI(
    SD::USERS_PATH . $_SERVER['PHP_AUTH_USER']
  );
}

#try {
#  if ( empty($_SERVER['PHP_AUTH_DIGEST']) ||
#       !( $data = SD::http_digest_parse($_SERVER['PHP_AUTH_DIGEST']) ) ||
#       !( $principal = SD_Registry::inst()->resource( DAV::parseURI(
#              SD::USERS_PATH . rawurlencode( $data['username'] )
#        ) ) )
#     )
#    throw new DAV_Status( DAV::HTTP_UNAUTHORIZED );
  // generate the valid response
#  $A1 = md5(
#    $data['username'] . ':' . SD::REALM . ':' . $principal->user_prop(SD::PROP_PASSWD)
#  );
#  $A2 = md5(
#    $_SERVER['ORIGINAL_REQUEST_METHOD'] . ':' . $data['uri']
#  );
#  $valid_response = md5(
#    $A1 . ':' . $data['nonce'] . ':' . $data['nc'] . ':' . $data['cnonce'] .
#    ':' . $data['qop'] . ':' . $A2
#  );
#  if ($data['response'] != $valid_response)
#    throw new DAV_Status( DAV::HTTP_UNAUTHORIZED );
#  if ('guest' != $data['username'])
#    SD_ACL_Provider::inst()->CURRENT_USER_PRINCIPAL = $principal->path;
#}
#catch (DAV_Status $e) {
#  $e->output();
#  exit();
#}

//if ( !isset($_SERVER['PHP_AUTH_USER']) ||
//     ! (( $principal = SD_Registry::inst()->resource(
//            DAV::parseURI( SD::USERS_PATH . rawurlencode( $_SERVER['PHP_AUTH_USER'] ) )
//          ) )) ||
//     @$_SERVER['PHP_AUTH_PW'] != $principal->user_prop(SD::PROP_PASSWD) ) {
//  $status = new DAV_Status(DAV::HTTP_UNAUTHORIZED);
//  $status->output();
//  exit();
//}
//SD_ACL_Provider::inst()->CURRENT_USER_PRINCIPAL = $principal->path;


$request = DAV_Request::inst();
if ($request) {
  $request->handleRequest();
}
//DAV::debug('done!');
