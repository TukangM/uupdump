UUP dump API
------------

### Functions
#### fetchupd.php: `uupFetchUpd($arch, $ring, $flight, $build, $minor, $sku, $type, $cacheRequests);`
Fetches latest update information from Windows Update servers.

Parameters:
 - `arch` - Architecture of build to find
   - **Supported values:** `amd64`, `x86`, `arm64`, `all`

 - `ring` - Channel to use when fetching information (Previously called Ring)
   - **Supported values:** `Canary`, `Dev`, `Beta`, `ReleasePreview`, `Retail`
   - **Supported Ring values :** `WIF`, `WIS`, `RP`

 - `flight` - Content type to use when fetching information (Previously called Flight)
   - **Supported values:** `Mainline`
   - **Supported Flight values:** `Active`, `Skip`, `Current`
   - **NOTE:** `Skip` is for `WIF` ring only. `Current` is for `RP` ring only.

 - `build` - Build number to use when fetching information
   - **Supported values:** >= 9841 and <= PHP_INT_MAX-1

 - `minor` - Build minor to use when fetching information
   - **Supported values:** >= 0 and <= PHP_INT_MAX-1

 - `sku` - SKU number to use when fetching information
   - **Supported values:** Any integer

 - `type` - Release type to use when fetching information for Windows Core OS (WCOS), e.g. Windows 10X
   - **Supported values:** `Production`, `Test`

 - `cacheRequests` - Should request responses be cached? (optional)
   - **Supported values:** 0 = Disable (default), 1 = Enable

#### get.php: `uupGetFiles($updateId, $usePack, $desiredEdition, $requestType);`
Fetches files from `updateId` update and parses to array.

Parameters:
 - `updateId` - Update identifier
   - **Supported values:** any update UUID

 - `usePack` - Generate list of files for selected language
   - **Supported values:** language name in xx-xx format

 - `desiredEdition` - Generate list of files for selected edition
   - **Supported values:** any update UUID
   - **NOTE:** You need to specify `usePack` to get successful request

 - `$requestType` - Type of request to the API (optional)
   - **Supported values:**
     - 0 = uncached request (default)
     - 1 = use cache if available
     - 2 = offline information retrieval

#### listeditions.php: `uupListEditions($lang, $updateId);`
Outputs list of supported editions for selected language and Update ID.

Parameters:
 - `lang` - Generate list for selected language
   - **Supported values:** language name in xx-xx format

 - `updateId` - Update identifier (optional)
   - **Supported values:** any update UUID

#### listid.php: `uupListIds($search, $sortByDate);`
Outputs list of updates in fileinfo database.

Parameters:
 - `search` - Search query (optional)
   - **Supported values:** any text

 - `sortByDate` - Sort results by creation date (optional)
   - **Supported values:** 0 = Disable, 1 = Enable


#### listlangs.php: `uupListLangs($updateId);`
Outputs list of languages supported for specified Update ID.

Parameters:
 - `updateId` - Update identifier (optional)
   - **Supported values:** any update UUID


#### updateinfo.php: `uupUpdateInfo($updateId, $onlyInfo, $ignoreFiles);`
Outputs specified information of specified `updateId`.

Parameters:
 - `updateId` - Update identifier
   - **Supported values:** any update UUID

 - `onlyInfo` - Key to output
   - **Supported values:** any string

 - `ignoreFiles` - Skips the `files` key in the output
   - **Supported values:** `true` or `false`

#### shared/main.php: `uupApiVersion();`
Returns version of the API.

Parameters:
 - None

#### shared/utils.php: `uupApiCheckUpdateId($updateId);`
Checks if the provided update ID is correctly formatted.

Parameters:
 - `updateId` - update ID to check
   - **Supported values:** Any string

#### shared/utils.php: `uupApiIsServer($skuId);`
Checks if the provided SKU ID is a Windows Sever SKU.

Parameters:
 - `skuId` - SKU ID to check
   - **Supported values:** Any integer

#### shared/utils.php: `uupApiBuildMajor($build);`
Returns a build major of the build number.

Parameters:
 - `build` - Build number (for example 22621.1) to split
   - **Supported values:** Any correctly formatted build number

### Error codes thrown by API
**fetchupd.php**
 - UNKNOWN_ARCH
 - UNKNOWN_RING
 - UNKNOWN_FLIGHT
 - UNKNOWN_COMBINATION
 - ILLEGAL_BUILD
 - ILLEGAL_MINOR
 - NO_UPDATE_FOUND
 - EMPTY_FILELIST

**get.php**
 - UNSUPPORTED_LANG
 - UNSPECIFIED_LANG
 - UNSUPPORTED_EDITION
 - UNSUPPORTED_COMBINATION
 - EMPTY_FILELIST
 - MISSING_FILES
 - NO_FILES
 - XML_PARSE_ERROR

**listeditions.php**
 - UNSUPPORTED_LANG

**listid.php**
 - NO_FILEINFO_DIR
 - SEARCH_NO_RESULTS

**updateinfo.php**
 - UPDATE_INFORMATION_NOT_EXISTS
 - KEY_NOT_EXISTS
