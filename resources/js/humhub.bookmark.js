humhub.module('bookmark', function (module, require, $) {
    var client = require('client');
    var additions = require('ui.additions');
    var Component = require('action').Component;

    var toggleBookmark = function (evt) {
        client.post(evt).then(function (response) {
            if(response.currentUserBookmarked) {
                additions.switchButtons(evt.$trigger, evt.$trigger.siblings('.unbookmark'));
                var component = Component.closest(evt.$trigger);
                if(component) {
                    component.$.trigger('humhub:bookmark:bookmarked');
                }
            } else {
                additions.switchButtons(evt.$trigger, evt.$trigger.siblings('.bookmark'));
            }
            
            _updateCounter(evt.$trigger.parent(), response.bookmarkCounter);
        }).catch(function (err) {
            module.log.error(err, true);
        });
    };

    var _updateCounter = function($element, count) {
        if (count) {
            $element.find(".bookmarkCount").html('(' + count + ')').show();
        } else {
            $element.find(".bookmarkCount").hide();
        }

    };

    module.export({
        toggleBookmark: toggleBookmark
    });
});