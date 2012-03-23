(function() {
  var $;

  $ = jQuery;

  $.decayingUpdate = function(url, options, callback, autoStopCallback) {
    var ajaxSettings, autoStop, boostPeriod, calls, getData, handle, maxCalls, noChange, originalMaxCalls, previousData, remoteData, resetTimer, settings, timer, timerInterval;
    settings = $.extend(true, {
      url: url,
      cache: false,
      method: 'GET',
      data: '',
      initialTimeout: 2000,
      multiplier: 1.7,
      maxCalls: 0,
      autoStop: 0
    }, options);
    timer = null;
    timerInterval = settings.initialTimeout;
    maxCalls = settings.maxCalls;
    originalMaxCalls = maxCalls;
    autoStop = settings.autoStop;
    calls = 0;
    noChange = 0;
    resetTimer = function(interval) {
      if (timer !== null) clearTimeout(timer);
      timerInterval = interval;
      return timer = setTimeout(getData, timerInterval);
    };
    boostPeriod = function() {
      var after, before;
      if (settings.multiplier >= 1) {
        before = timerInterval;
        timerInterval = timerInterval * settings.multiplier;
        if (timerInterval > settings.maxTimeout) {
          timerInterval = settings.maxTimeout;
        }
        after = timerInterval;
        return resetTimer(timerInterval);
      }
    };
    ajaxSettings = jQuery.extend(true, {}, settings);
    if (settings.type && !ajaxSettings.dataType) {
      ajaxSettings.dataType = settings.type;
    }
    if (settings.data) ajaxSettings.data = settings.data;
    ajaxSettings.type = settings.method;
    ajaxSettings.ifModified = true;
    handle = {
      restart: function() {
        maxCalls = originalMaxCalls;
        calls = 0;
        return resetTimer(timerInterval);
      },
      stop: function() {
        return maxCalls = -1;
      }
    };
    getData = function() {
      var toSend;
      toSend = jQuery.extend(true, {}, ajaxSettings);
      if (typeof settings.data === 'function') {
        toSend.data = settings.data;
        if (typeof toSend.data === 'number') toSend.data = toSend.data.toString();
      }
      if (maxCalls === 0) {
        return $.ajax(toSend);
      } else if (maxCalls > 0 && calls < maxCalls) {
        $.ajax(toSend);
        return calls++;
      }
    };
    remoteData = null;
    previousData = null;
    ajaxSettings.success = function(data) {
      return remoteData = data;
    };
    ajaxSettings.complete = function(xhr, success) {
      var rawData;
      if (maxCalls === -1) return;
      if (success === 'success' || success === 'notmodified') {
        rawData = $.trim(xhr.responseText);
        if (rawData === 'STOP_AJAX_CALLS') handle.stop();
        if (previousData === rawData) {
          if (autoStop > 0) {
            noChange++;
            if (noChange === autoStop) {
              handle.stop();
              if (autoStopCallback) autoStopCallback(noChange);
            }
          }
          boostPeriod();
        } else {
          noChange = 0;
          resetTimer(settings.initialTimeout);
          previousData = rawData;
          if (remoteData === null) remoteData = rawData;
          if ((ajaxSettings.dataType === "json") && (typeof remoteData === "string") && (success === "success")) {
            remoteData = JSON.parse(remoteData);
          }
          if (settings.success) settings.success(remoteData, success, xhr, handle);
          if (callback) callback(remoteData, success, xhr, handle);
        }
      }
      return remoteData = null;
    };
    ajaxSettings.error = function(xhr, textStatus) {
      if (textStatus === 'notmodified') {
        previousData = null;
        resetTimer(settings.initialTimeout);
        if (settings.error) return settings.error(xhr, textStatus);
      }
    };
    jQuery(function() {
      return resetTimer(timerInterval);
    });
    return handle;
  };

}).call(this);