<?php

/*
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @group storage
 */
function queryfx(PhutilDatabaseConnection $conn, $sql/*, ... */) {
  $argv = func_get_args();
  $query = call_user_func_array('qsprintf', $argv);
  return $conn->executeRawQuery($query);
}

/**
 * @group storage
 */
function vqueryfx($conn, $sql, $argv) {
  array_unshift($argv, $conn, $sql);
  return call_user_func_array('queryfx', $argv);
}

/**
 * @group storage
 */
function queryfx_all($conn, $sql/*, ... */) {
  $argv = func_get_args();
  $ret = call_user_func_array('queryfx', $argv);
  return $conn->selectAllResults($ret);
}

/**
 * @group storage
 */
function queryfx_one($conn, $sql/*, ... */) {
  $argv = func_get_args();
  $ret = call_user_func_array('queryfx_all', $argv);
  if (count($ret) > 1) {
    throw new PhutilQueryCountException(
      'Query returned more than one row.');
  } else if (count($ret)) {
    return reset($ret);
  }
  return null;
}