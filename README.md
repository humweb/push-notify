# Pusher Private Notifications

[![Build Status](https://travis-ci.org/humweb/push-notify.svg?branch=master)](https://travis-ci.org/humweb/push-notify)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/humweb/push-notify/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/humweb/push-notify/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/humweb/push-notify/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/humweb/push-notify/?branch=master)


## Examples

**Create a private channel**
```
    // For current user
    $channel = new PrivateChannel(PushAuth::driver());

    // Or a specific user
    $channel = PrivateChannel::forUser(33);
```

**Setup route for authentication**
```
Route::post('push-auth', function(Request $request) {
    // For current user
    $channel = new PrivateChannel(PushAuth::driver());

    $response = $channel->auth($request->channel_name, $request->socket_id);

    if ($response) {
        return $response;
    } else {
        die('not authorized.');
    }
});
```

**Trigger event on channel**
```
    $channel = new PrivateChannel(PushAuth::driver());

    $channel->fire('notify', [
        'title' => 'Message from jane doe.',
        'body' => 'Here is the body of the message.'
    ]);
```

**Browser client setup**

HTML
```
<div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        Notifications <span id="notification-count" class="badge"></span>
    </button>
    <ul class="dropdown-menu notifications">
    </ul>
</div>
```

Javascript
```
    var $menu = $('.notifications').pushMenu({
        countEl: '#notification-count'
    })

    var pusher = new Pusher('<YourCodeGoesHere>', {
        encrypted: true,
        authEndpoint: '/push-auth'
    });

    var channel = pusher.subscribe('private-notifications-{{ $user->id }}');
    channel.bind('notify', function (data) {
        $menu.trigger('pushmenu.add', data);
    });
```
