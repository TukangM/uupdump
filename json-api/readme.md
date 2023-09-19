# UUP dump JSON API

## Description
A simple endpoint allowing access to the UUP dump API using simple HTTP GET requests.

## Usage
All requests are done using GET requests with parameters specified in the URL.
Responses are provided in JSON format.

Responses from the UUP dump API are always returned in the `response` key.

If request fails, a HTTP error code will be set to:
  - `400` if request was malformed
  - `429` if user is being rate limited
  - `500` if retrieval of data was unsuccessful

In such cases `response` key will contain an `error` key with short description
of the error.

## Supported endpoints
### `/` or `/index.php`
Returns versions of both JSON and UUP dump APIs

Parameters:
  - None

#### JSON response format:
```javascript
{
  "response": {
    "apiVersion":"string" // Current UUP dump API version
  },
  "jsonApiVersion": "string" // Current JSON API version
}
```

### `/listid.php`
Returns a list of builds in the local database. (like "Browse the list of known builds" on the website)

Parameters:
 - `search` - Optional search query
   - **Supported values:** any text

 - `sortByDate` - Optional sorting results by creation date
   - **Supported values:** 0 = Disable, 1 = Enable

#### JSON response format:
```javascript
{
  "response": {
    "apiVersion":"string", // Current UUP dump API version
    "builds": [
      {
        "title": "string", // Update title, for example Windows 10 Insider Preview 19577.1000 (rs_prerelease)
        "build": "string", // Update build number, for example 19577.1000
        "arch": " string", // Update architecture, for example amd64
        "created": 1234567890, // Timestamp of when the build was added to the database
        "uuid": "string" // UUID Update Identifier
      },
      ...
    ]
  },
  "jsonApiVersion": "string" // Current JSON API version
}
```

### `/fetchupd.php`
Fetches the latest builds from Windows Update servers using specified
parameters. (like "Fetch the latest build" on the website)

Parameters:
 - `arch` - Specifies which architecture the API will return.
   - **Supported values:** `amd64`, `x86`, `arm64`, `all`

 - `ring` - Specifies the channel (ring) the API uses when querying Windows Update servers.
   - **Supported values:** `Dev`, `Beta`, `ReleasePreview`, `Retail`
   - **Supported Ring values :** `WIF`, `WIS`, `RP`, `RETAIL`

 - `flight` - Content (Flight) tye to use when fetching information
   - **Supported values:** `Mainline`
   - **Supported Flight values:** `Active`, `Skip`, `Current`
   - **NOTE:** `Skip` is for `WIF` ring only. `Current` is for `RP` ring only.

 - `build` - Build number to use by the API when fetching information
   - **Supported values:** >= 9841 and <= PHP_INT_MAX-1

 - `sku` - SKU number to use when fetching information
   - **Supported values:** Any SKU integer

 - `type` - Release type to use when fetching information for Windows Core OS (WCOS), e.g. Windows 10X
   - **Supported values:** `Production`, `Test`

#### JSON response format:
```javascript
{
  "response": {
    "apiVersion": "string", // Current UUP dump API version
    "updateId": "string", // UUID Update Identifier
    "updateTitle": "string", // Update title, such as Windows 10 Insider Preview 19577.1000 (rs_prerelease)
    "foundBuild": "string", // Update build number, such as 19577.1000
    "arch": "string", // Update architecture, such as amd64/x86/arm64
    "fileWrite": "string", // NO_SAVE if the build was already in the database, INFO_WRITTEN if it was just added to it.
    "updateArray": [
      {
        "updateId": "string", // UUID Update Identifier
        "updateTitle": "string", // Update title, such as Windows 10 Insider Preview 19577.1000 (rs_prerelease)
        "foundBuild": "string", // Update build number, such as 19577.1000
        "arch": "string", // Update architecture, such as amd64/x86/arm64
        "fileWrite": "string" // NO_SAVE if the build was already in the database, INFO_WRITTEN if it was just added to it.
      }
    ]
  },
  "jsonApiVersion": "string" // Current JSON API version
}
```

### `/get.php`
Retrieves download links for specified Update ID and provides lists of ready to
use UUP sets.

Parameters:
 - `id` - Update identifier (UUID string)
   - **Supported values:** Any valid update identifier in the UUID format, may include revision in the following format: "UUID_rev.2".

 - `lang` - Create UUP set for selected language (optional)
   - **Supported values:** Language name in xx-xx format.

 - `edition` - Create UUP set for the selected edition (optional)
   - **Supported values:** Any edition name.
   - **NOTE:** Must be used with `lang`.

 - `noLinks` - Do not retrieve download links for the created UUP set (optional)
   - **Supported values:** 0 = Disable (Retrieve links), 1 = Enable (No links)

#### JSON response format:
```javascript
{
  "response": {
    "apiVersion": "string", // Current UUP dump API version
    "updateName": "string", // Update title, such as Windows 10 Insider Preview 19577.1000 (rs_prerelease)
    "arch": "string", // Update architecture, for example x86
    "build": "string", // Update build number, for example 19577.1000
    "files": { // All files contained in the package
      "string": { // File name, such as 'core_en-us.esd', 'microsoft-windows-client-features-package.esd', etc.
        "sha1": "string", // The file's SHA1 checksum.
        "size": "string", // File size in bytes
        "url": "string", // File download link, 'null' if noLinks=1
        "uuid": "string", // File UUIDv4, 'null' if noLinks=1 used
        "expire": "string", // Link expiration date, '0' if noLinks=1 used
        "debug": "string" // Raw data from Microsoft servers, 'null' if noLinks=1 used
      },
      ...
    }
  },
  "jsonApiVersion": "string" // Current JSON API version
}
```

### `/listlangs.php`
Lists available languages for the specified Update ID.

Parameters:
 - `id` - Optional Update identifier (UUID string)
   - **Supported values:** Any valid update identifier in the UUID format,  may include revision in the following format: "UUID_rev.2".

#### JSON response format:
```javascript
{
  "response": {
    "apiVersion": "string", // Current UUP dump API version
    "langList": [
      "en-gb", // Short language name, xx-xx format.
      ...
    ],
    "langFancyNames": {
      "en-gb": "English (United Kingdom)", // key-value pairs of xx-xx to full language name.
      ...
    }
  },
  "jsonApiVersion": "string" // Current JSON API version
}
```

### `/listeditions.php`
Lists available editions for the specified Update ID.

Parameters:
- `lang` - Generate edition list for the selected language
   - **Supported values:** Language name in xx-xx format

 - `id` - Optional update identifier (UUID string)
   - **Supported values:** Any valid update identifier in the UUID format, may include revision in the following format: "UUID_rev.2".

#### JSON response format:
```javascript
{
  "response": {
    "apiVersion": "string", // Current UUP dump API version
    "editionList": [
      "CLOUD", // Short edition name
      ...
    ],
    "editionFancyNames": {
      "CLOUD": "Windows 10 S", // key-value pairs of edition name to fancy edition name.
      ...
    }
  },
  "jsonApiVersion": "string" // Current JSON API version
}
```
