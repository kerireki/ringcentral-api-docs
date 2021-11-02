require 'ringcentral'
require 'dotenv/load'

CLIENTID     = ENV['RC_CLIENT_ID']
CLIENTSECRET = ENV['RC_CLIENRT_SECRET']
SERVER       = ENV['RC_SERVER_URL']
USERNAME     = ENV['RC_USERNAME']
PASSWORD     = ENV['RC_PASSWORD']
EXTENSION    = ENV['RC_EXTENSION']
RECIPIENT    = ENV['RINGOUT_RECIPIENT']

$rc = RingCentral.new(CLIENTID, CLIENTSECRET, SERVER)
$rc.authorize(username: USERNAME, extension: EXTENSION, password: PASSWORD)

resp = $rc.post('/restapi/v1.0/account/~/extension/~/ring-out', payload: {
    from: { phoneNumber: USERNAME },
    to: { phoneNumber: RECIPIENT },
    playPrompt: false
})

puts "Call placed. Call status: " + resp.body['status']['callStatus']
