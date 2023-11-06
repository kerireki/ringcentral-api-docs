# Migrating from PubNub to WebSockets

RingCentral's use of PubNub is officially deprecated and will eventually be discontinued. All developers are required to migrate their applications to use WebSockets instead. Depending upon how you have implemented PubNub, your migration path may vary, and this guide will hopefully put you on the right path. 

## Add the WebSocketsSubscription app scope to your app

With the introduction of WebSockets we are making another change to the platform. Currently we support a single app scope called Subscriptions, which we will breaking out into three distinct scopes:

* Webhook Subscriptions
* PubNub Subscriptions
* WebSockets Subscriptions

We are attempting to update everyone's apps on their behalf to ease the migration experience, but developers should double check their app and confirm that the necessary app scopes are present. If they are not, please add them. 

## Migrate your code to use WebSockets

In migrating away from PubNub, every developer will need to make as least some small change to their code. The size and nature of that change will depend almost entirely upon your specific implementation, which can fall into two main buckets.

#### Migrating code manually for self-built SDKs

Some developers choose not to use an SDK provided by RingCentral. If this is the case for you, then you will need to make a number of changes to switch to the WebSockets. We have two guides that walk through how we have implemented WebSockets to help you with this process:

* [Subscribing to WebSockets](../subscribing/)
* [Receiving events via WebSockets](../receiving/)

Even if you do not use a RingCentral SDK, we strongly recommend using a third-party library to help implement the WebSockets protocol.

#### Upgrading your RingCentral SDK

If you use a [RingCentral SDK](../../../sdks/), then you will need to update the most recent version of that SDK, and make a few changes to your source code. The following will provide the SDK-specific instructions to guide you in this process. 

=== "Javascript"

    Upgrade [ringcentral-js](https://www.npmjs.com/package/@ringcentral/sdk) to version 5.0.0 or later.
    
    There are no code changes you will need to make. When you upgrade to the latest version of the SDK, it will automatically begin using WebSockets if you were once using PubNub.
    
=== "Python"

    Upgrade [ringcentral-python](https://pypi.org/project/ringcentral/) to version 0.8.0 or later.
	
	**Before**
    ```python
    {!> code-samples/websockets/migration-before.py !} 
    ```
   
    **After**
    ```python
    {!> code-samples/websockets/migration-after.py !} 
    ```

=== "PHP"

    Upgrade [ringcentral-php](https://github.com/ringcentral/ringcentral-php) to version 3.0.0 or later.
    
    **Before**
    ```php hl_lines="11 16"
    {!> code-samples/websockets/migration-before.php !} 
    ```
    
    **After**
    ```php hl_lines="2 12-13 15"
    {!> code-samples/websockets/migration-after.php !} 
    ```

=== "Java"

    Upgrade [ringcentral-java](https://mvnrepository.com/artifact/com.ringcentral/ringcentral) to version 3.0 or later.
    
    **Before**
    ```java hl_lines="7"
    {!> code-samples/websockets/migration-before.java !} 
    ```
    
    **After**
    ```java hl_lines="7"
    {!> code-samples/websockets/migration-after.java !} 
    ```

=== "C#"

    Upgrade [RingCentral.Net](https://github.com/ringcentral/RingCentral.Net) to version 6.0 or later.
    
    **Before**
    ```c# hl_lines="10 18-19 22"
    {!> code-samples/websockets/migration-before.cs !} 
    ```
    
    **After**
    ```c# hl_lines="3 10 18-19 22"
    {!> code-samples/websockets/migration-after.cs !} 
    ```

=== "Ruby"

    Upgrade [ringcentral-ruby](https://rubygems.org/gems/ringcentral-sdk/versions/0.8.1) to version TODO or later.
    
    **Before**
    ```ruby
    {!> code-samples/websockets/migration-before.rb !} 
    ```
    
    **After**
    ```ruby
    {!> code-samples/websockets/migration-after.rb !} 
    ```

## Remove the PubNubSubscription app scope from your application

The final step in your migration is to remove the PubNub Subscription app scope from your app via the Developer Console. When this is done, PubNub will be disabled in your account, and your migration will be complete. 
