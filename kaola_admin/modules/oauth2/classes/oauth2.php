<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @file
 * Sample OAuth2 Library PDO DB Implementation.
 */

// Set these values to your database access info.
//define("PDO_DSN", "mysql:dbname=myoauth2;host=localhost");
//define("PDO_USER", "root");
//define("PDO_PASS", "");
//define("OAuth2_DB", "test"); // OAuth2相关表的数据库配置名称.具体名称请查阅：/api/application/config/database.php
define("OAuth2_DB", "default"); // OAuth2相关表的数据库配置名称.具体名称请查阅：/api/application/config/database.php

/**
 * OAuth2 Library PDO DB Implementation.
 */
class Oauth2 extends Oauth2base {

//  private $db;

  /**
   * Overrides OAuth2Base::__construct().
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Release DB connection during destruct.
   */
  function __destruct() {}


  /**
   * Little helper function to add a new client to the database.
   *
   * @param $client_id
   *   Client identifier to be stored.
   * @param $client_secret
   *   Client secret to be stored.
   * @param $redirect_uri
   *   Redirect URI to be stored.
   */
  public function addClient($client_id, $client_secret, $redirect_uri) {
    $query = DB::query(Database::INSERT, "INSERT INTO api_clients (client_id, client_secret, redirect_uri) VALUES (:client_id, :client_secret, :redirect_uri)");
	$query->param(':client_id', $client_id);
	$query->param(':client_secret', $client_secret);
	$query->param(':redirect_uri', $redirect_uri);
	$query->execute(OAuth2_DB);
  }

  /**
   * Implements OAuth2Base::checkClientCredentials().
   */
  protected function checkClientCredentials($client_id, $client_secret = NULL) {
    $query = DB::query(Database::SELECT, "SELECT client_secret FROM api_clients WHERE client_id = :client_id");
	$query->param(':client_id', $client_id);
	$result = $query->execute(OAuth2_DB)->current();
	//必须提供密钥
//	if ($client_secret === NULL)
//		return $result !== FALSE;

	return $result["client_secret"] == $client_secret;
  }

  protected function getServerSecret($client_id) {
    $query = DB::query(Database::SELECT, "SELECT server_secret FROM api_clients WHERE client_id = :client_id");
	$query->param(':client_id', $client_id);
	$result = $query->execute(OAuth2_DB)->current();

	return $result["server_secret"];
  }

  /**
   * Implements OAuth2Base::getRedirectUri().
   */
  protected function getRedirectUri($client_id) {
    $query = DB::query(Database::SELECT, "SELECT redirect_uri FROM api_clients WHERE client_id = :client_id");
	$query->param(':client_id', $client_id);
	$result = $query->execute(OAuth2_DB)->current();
	if ($result === FALSE)
          return FALSE;

    return isset($result["redirect_uri"]) && $result["redirect_uri"] ? $result["redirect_uri"] : NULL;
  }

  /**
   * Implements OAuth2Base::getAccessToken().
   */
  protected function getAccessToken($oauth_token) {
    $query = DB::query(Database::SELECT, "SELECT client_id, expires, scope,username,suid FROM api_tokens WHERE oauth_token = :oauth_token");
	$query->param(':oauth_token', $oauth_token);
	$result = $query->execute(OAuth2_DB)->current();
	return $result !== FALSE ? $result : NULL;
  }

  /**
   * Implements OAuth2Base::setAccessToken().
   */
  protected function setAccessToken($oauth_token, $client_id, $expires, $scope = NULL,$username,$suid) {
    $query = DB::query(Database::INSERT, "INSERT INTO api_tokens (oauth_token, client_id, expires, scope,username,suid) VALUES (:oauth_token, :client_id, :expires, :scope, :username,:suid)");
	$query->param(':oauth_token', $oauth_token);
	$query->param(':username', $username);
	$query->param(':client_id', $client_id);
	$query->param(':expires', $expires);
	$query->param(':scope', $scope);
	$query->param(':suid', $suid);
	$query->execute(OAuth2_DB);
  }

  /**
   * Overrides OAuth2Base::getSupportedGrantTypes().
   *    * return array(
   *   OAUTH2_GRANT_TYPE_AUTH_CODE,
   *   OAUTH2_GRANT_TYPE_USER_CREDENTIALS,
   *   OAUTH2_GRANT_TYPE_ASSERTION,
   *   OAUTH2_GRANT_TYPE_REFRESH_TOKEN,
   *   OAUTH2_GRANT_TYPE_NONE,
   * );
   */
  protected function getSupportedGrantTypes() {
    return array(
      OAUTH2_GRANT_TYPE_AUTH_CODE,
//      OAUTH2_GRANT_TYPE_REFRESH_TOKEN,
      OAUTH2_GRANT_TYPE_USER_CREDENTIALS,
    );
  }

  /**
   * Overrides OAuth2Base::getAuthCode().
   */
  protected function getAuthCode($code) {
    $query = DB::query(Database::SELECT, "SELECT code, client_id, redirect_uri, expires, scope FROM api_auth_codes WHERE code = :code");
	$query->param(':code', $code);
	$result = $query->execute(OAuth2_DB)->current();
	return $result !== FALSE ? $result : NULL;
  }

  /**
   * Overrides OAuth2Base::setAuthCode().
   */
  protected function setAuthCode($code, $client_id, $redirect_uri, $expires, $scope = NULL) {
    $query = DB::query(Database::INSERT, "INSERT INTO api_auth_codes (code, client_id, redirect_uri, expires, scope) VALUES (:code, :client_id, :redirect_uri, :expires, :scope)");
	$query->param(':code', $code);
	$query->param(':client_id', $client_id);
	$query->param(':redirect_uri', $redirect_uri);
	$query->param(':expires', $expires);
	$query->param(':scope', $scope);
	$query->execute(OAuth2_DB);
  }
}
