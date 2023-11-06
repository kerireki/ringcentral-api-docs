# Working with media content

## Downloading media

A number of RingCentral APIs make available to developers access to media files that one may want to download, stream or embed somewhere. Here are a few examples of such media files:

* Call Recordings
* Voicemails
* Fax Documents
* MMS attachments
* Greetings
* Compliance Exports

### Download URLs for media content

All media files can be accessed via a URL returned via an API Call. For example, the following shows a response payload from the RingCentral Message Store which refers to a received fax document that a developer can download. *It has been truncated for brevity*. 

!!! note "Rate Limits"
    Please note that media resources may have different rate limit plans. Retrieving call recordings using the API is subject to throttling so please analyze the `X-Rate-Limit-Group` header to understand the limit to the call recording you are trying to retrieve.

```json hl_lines="21 22"
{
  "uri" : "https://platform.ringcentral.com/restapi/v1.0\
    /account/230919004/extension/230919004/message-store\
    ?messageType=Fax&availability=Alive&dateFrom=2018-10-07T09:19:00.000Z\
    &page=1&perPage=100",
  "records" : [ ... ,
    {
      "uri": "https://platform.ringcentral.com/restapi/v1.0\
        /account/230919004/extension/230919004/message-store/5209304004",
      "id": 5209304004,
      "from": {
        "phoneNumber": "+12125557464"
      },
      "type": "Fax",
      "creationTime": "2018-10-08T09:17:27.000Z",
      "readStatus": "Unread",
      "priority": "Normal",
      "attachments": [
        {
          "id": 5209304004,
          "uri": "https://media.ringcentral.com/restapi/v1.0\
            /account/230919004/extension/230919004/message-store/5209304004/content/5209304004",
          "type": "RenderedDocument",
          "contentType": "application/pdf"
        }
      ],
      "direction": "Inbound",
      "availability": "Alive",
      "subject": "+12125559976",
      "messageStatus": "Received",
      "faxResolution": "High",
      "faxPageCount": 1,
      "lastModifiedTime": "2018-10-08T09:17:27.227Z"
    },
  ... ],
  "paging" : {
    // snipped
  },
  "navigation" : {
    // snipped
  }  
```

### Downloading protected content

Often a media asset you need to download requires authentication. Your app or script can download the file programmatically in one of the following two ways.

#### Authorization header

The first and recommended way to pass your authentication credentials to a media URL is through an HTTP Authorization header. Use the same access token credential used to call the API to retrieve protected media content as shown below:

```http
GET https://some.server.ringcentral.com/path/to/protected/file
Authorization: Bearer <your access token>
```

If you are downloading via cURL, the command would be:

```bash
curl -H "Authorization: Bearer <access token>" \
    https://some.server.ringcentral.com/path/to/protected/file
```

#### Query parameter

by appending an `access_token` parameter to the URL. The value of this parameter is your authentication token typically transmitted in your Authorization header when making API calls. For example:

    https://media.ringcentral.com/path/to/protected/file?access_token=U0pDMTF...3xBUQ

!!! warning "The access_token query parameter is only supported on media.ringcentral.com. It is not supported for Glip."

### Downloading partial content

There are times you may need to download large files in pieces. Perhaps your HTTP client has an aggressive timeout, or it would be a more efficient use of resources. Regardless, one can download any media resource within RingCentral in pieces by passing [HTTP Range headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Range_requests) in their request.


```http
GET /account/230919004/extension/230919004/message-store/5209304004/content/5209304004 HTTP/1.1
Host: media.ringcentral.com
Range: bytes=0-1023
```

#### HTTP 206 Partial

Developers should also be aware of the potential that the server may respond with a 206 Partial response code indicating that only part of the file is being returned. In the event you received this header, you will need to download the file in chunks according to the [standard](https://tools.ietf.org/html/rfc7233).

## Uploading media content

Some endpoints allow users to upload media content, in particular:

* SMS API - for sending files via SMS
* Fax API - for sending documents
* Greetings API - for uploading audio greetings

### Supported media types

**Obviously, some media types are only relevant or possible in specific mediums. Video content for example cannot be transmitted via Fax. The list below therefore shows all the media types our platform is capable of supporting, but may not represent what media types are necessarily appropriate/relevant:**

* application/gzip
* application/rtf
* application/zip
* audio/amr
* audio/mp4
* audio/mpeg
* image/bmp
* image/gif
* image/jpeg
* image/png
* image/tiff
* text/vcard
* video/mp4
* video/mpeg
