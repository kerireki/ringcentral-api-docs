# Introduction to Call Control

The Call Control API is a REST-based interface, allowing developers to customize and integrate your phone system everywhere. It will help you build creative solutions based on our phone service and improve customer communications experience. The Call Control API makes it easy to make, retrieve, control and monitor calls.

!!! check "Important prerequisite"
    The Call Control API requires the "Advanced User" permission. This permission must be enabled for your account by a RingCentral account manager or administrator. 

## Using the Call Control API

To control a call, a developer must first identify the specific call (or "session") and in some cases the specific person (or "party") they wish to manipulate. Here are two common ways of discovering this information.

!!! info "Try the Call Control SDK"
    We created the [Call Control SDK](https://github.com/ringcentral/ringcentral-call-control-js) to help Javascript developers call these APIs using a more functional coding style, and handle TelephonySession notifications more easily.

### Generate a list of active calls

A developer can use a REST API to generate a list of all active calls (or "sessions") within an organization, or for a specific user. From the list returned, one can then fetch detail session information about an individual session. 

<a class="btn btn-secondary" href="../finding-active-calls/">Read about generating a list of active calls &raquo;</a>

### Receive events relating to session state changes

Developers can also subscribe to events and receive notifications whenever the state of session changes. 

<a class="btn btn-secondary" href="../call-control-sessions/">Read about subscribing to Telephony Session events &raquo;</a>

### Fetching detailed session information

Given a `telephonySessionId` one can then fetch detailed information about the session, including a list of all the parties on that call, as follows:

**Request**

```http
GET /restapi/v1.0/account/~/telephony/sessions/<telephonySessionId>
Content-Type: application/json
Authorization: Bearer <access-token>
```

**Response**

```json
{
    "creationTime": "2018-08-01T13:36:09Z",
    "id": "Y3MxNzE4MzU2NzgxNTM2MTY1NDhAMTAuNjIuMS4zMA",
    "origin": {
        "type": "Call"
    },
    "parties": [
        {
            "direction": "Outbound",
            "from": {
                "extensionId": "400415045004",
                "name": "The Cat Jerry",
                "phoneNumber": "+18885551932"
            },
            "id": "cs171835678153616548-1",
            "muted": false,
            "owner": {
                "accountId": "400415035004",
                "extensionId": "400415045004"
            },
            "standAlone": false,
            "status": {
                "code": "Answered"
            },
            "to": {
                "extensionId": "400415042004",
                "name": "Tom Sawyer",
                "phoneNumber": "102"
            }
        },
        {
            "direction": "Inbound",
            "from": {
                "extensionId": "400415045004",
                "name": "TheCat Jerry",
                "phoneNumber": "103"
            },
            "id": "cs171835678153616548-2",
            "muted": false,
            "owner": {
                "accountId": "400415035004",
                "extensionId": "400415042004"
            },
            "standAlone": false,
            "status": {
                "code": "Answered"
            },
            "to": {
                "extensionId": "400415042004",
                "name": "Tom Sawyer",
                "phoneNumber": "102"
            }
        }
    ]
}
```

## Learn more

* Control an incoming a call before it is accepted: [Pre-call Controll](pre-call-control.md)
* Control an active call already in progress: [Active Call Control](active-call-control.md)
* Detect changes in the status of a call: [Telephony Session Notifications](telephony-session-notifications.md)


