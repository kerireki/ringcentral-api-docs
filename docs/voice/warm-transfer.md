# Managing warm transfers

During an active call with a customer, the agent may need to transfer the customer to another agent or supervisor. In the case of a warm transfer, the agent first puts the customer on hold and then calls another agent or supervisor. Once connected, the agent can have a conversation first with another agent or supervisor before completing the transfer. Completing the transfer means connecting another agent or supervisor with the customer and dropping the original agent from the call.

* Find the session ID and party ID for the customer-operator telephony session
* Find the session ID and party ID for the operator-consult telephony session
* Complete the transfer by connecting the customer to the consult and dropping the original operator

## Presumptions

Placing calls on hold and making calls to other parties is already covered by WebRTC and SIP requests.

## Use Case

In our example, a customer is calling an operator looking for assistance. The operator tries to help the customer, but the operator realizes they need to bring in a consult. The operator puts the customer on hold and dials the consult. After briefing the consult, the operator performs the warm transfer to the consult.

<img class="img-fluid" src="../../img/warm-transfer.png">

## Finding the Session ID and Party ID

The first step in a warm transfer is to put the customer on hold. But before that can happen, there is some information we need to gather about the customer and the operator. We need to collect the telephony session from the operator's perspective. We can do this through the [Extension Telephony Session Event](https://developers.ringcentral.com/api-reference/Extension-Telephony-Sessions-Event).

!!! Note
    An alternative option is to listen to the [Extension Presence Event](https://developers.ringcentral.com/api-reference/Extension-Presence-Event), which will also allow you to retrieve the session ID and party ID.

Follow the instructions for [setting up WebSockets](../notifications/websockets/quick-start.md). Here we will want to listen for Telephony Session Events so set an event filter for `/restapi/v1.0/account/~/extension/~/telephony/sessions`.

### Receive event for customer-to-operator call

You'll start to receive event messages for connected calls. The following is an example of an event showing the customer call being `answered` by the operator.

```json hl_lines="11 18 46"
{!> code-samples/voice/cust-to-oper-event.json !}
```

The highlighted lines show you the important fields you will need.

| Field | Description |
|-|-|
| `"extensionId": "684351005"` | This is the extension ID of the operator. This is the extension ID perspective we need to bridge the two calls in a warm transfer. |
| `"id": "p-a39d666edaab42fdaa476135027819bc-2"` | This party ID is linked to the ID for the extension ID above (the operator). |
| `"telephonySessionId": "s-a39d666edaab42fdaa476135027819bc"` | This is the telephony session ID for the call, or how the call between the customer and the operator is identified. |

### Receive event for operator-to-customer call

Next, you'll want to find the event for the operator calling and connecting to the consult. The following is an example of an event showing the operator call being `answered` by the consult.

```json hl_lines="11 18 37"
{!> code-samples/voice/oper-to-cust-event.json !}
```

The highlighted lines show you the important fields you will need.

| Field | Description |
|-|-|
| `"extensionId": "684351005"` | This is the extension ID of the operator. This is the extension ID perspective we need to bridge the two calls in a warm transfer. |
| `"id": "p-9d11ac1bba524888bffaaef0488557c3-1"` | This party ID is linked to the ID for the extension ID above (the operator). |
| `"telephonySessionId": "s-9d11ac1bba524888bffaaef0488557c3"` | This is the telephony session ID for the call, or how the call between the operator and the consult is identified. |

## Bridging the Two Parties (aka Warm Transfer)

Now that we've collected our two party IDs for the operator, and the two session IDs for each call, we are ready to bridge the parties together with the operator as the anchor. This means you need both party IDs that belong to the operator.

Take the party ID and the session ID of the call from the customer to the operator and put them in the path as shown.

```http
POST /restapi/v1.0/account/~/telephony/sessions/s-a39d666edaab42fdaa476135027819bc/parties/p-a39d666edaab42fdaa476135027819bc-2/bridge
```

!!! hint "Hint"
    A telephony session ID start with `s-` while a party ID starts with `p-` and ends with a `-` number. Look carefully to make sure you are not swapping your IDs.

Next we'll add the party ID and the session ID of the call from the operator to the consult and put them in the body as shown.

```json
{
  "telephonySessionId": "s-9d11ac1bba524888bffaaef0488557c3",
  "partyId": "p-9d11ac1bba524888bffaaef0488557c3-1"
}
```

By posting this API call, you will be bridging the customer with the consult and dropping the operator from the call.
