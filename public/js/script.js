$("#heroes").change(function () {
    $.ajax({
        type: 'GET',
        url: '/hero/' + $(this).val() + '/data?level=1',
        dataType: 'json',
        error: function () {
            $('#info').html('<p>Error fetching hero data</p>');
        },
        success: function (data) {
            $("#hero-data").attr("data-value", data.id);
            $(".hero-name").text(data.name);
            $(".hero-avatar").html($("<img />", {src: data.image}));
            $(".hero-hp").text(data.computed.currentHp);
            $(".hero-mp").text(data.computed.currentMp);
            $(".hero-hp-regen").text(data.computed.currentHpRegen);
            $(".hero-mp-regen").text(data.computed.currentMpRegen);
            $(".hero-base-str").text(data.baseStr);
            $(".hero-str-gain").text(data.strGain);
            $(".hero-base-agi").text(data.baseAgi);
            $(".hero-agi-gain").text(data.agiGain);
            $(".hero-base-int").text(data.baseInt);
            $(".hero-int-gain").text(data.intGain);
            $(".hero-attack").text(data.computed.currentDmgMin + '-' + data.computed.currentDmgMax);
            $(".hero-armor").text(data.computed.currentArmor);
            $(".hero-armor-percent").text(data.computed.currentArmorPercent);
            $(".hero-ms").text(data.computed.currentMs);
            for (var i = 0; i <= 7; i++) {
                $(".talent" + (i + 1)).attr("data-talentId", data.talents[i].id);
                $(".talent" + (i + 1)).text(data.talents[i].description);
            }
            $(".abilities").empty();
            $(data.abilities).each(function() {
                if(this.abilityNumber!==0){
                    $(".abilities").append(
                        $("<div class='ability'>" +
                            "<p class='ability-name'>"+this.abilityName+"</p>"+
                            "<div class='ability-descr'>"+this.description+"</div>"+
                            "<img class='ability-image' src='"+this.image+"'>"+
                            "</div>")
                    );
                }
            });
            $(data.abilities).each(function() {
                if(this.abilityNumber===0){
                    $(".abilities").append(
                        $("<div class='ability'>" +
                            "<p class='ability-name'>"+this.abilityName+"</p>"+
                            "<div class='ability-descr'>"+this.description+"</div>"+
                            "<img class='ability-image' src='"+this.image+"'>"+
                            "</div>")
                    );
                }
            });
        }
    });
});

$('#level').on('keyup change', function () {
    var heroId = $("#hero-data").attr("data-value");
    var level = $(this).val();
    var talents = $("#talents-data").attr("data-value");
    var items = $("#items-data").attr("data-value");
    var neutralItem = $("#neutral-item-data").attr("data-value");
    $.ajax({
        type: 'GET',
        url: '/hero/' + heroId + '/data?level=' + level + '&talents=' + talents + '&items=' + items + '&neutral-item=' + neutralItem,
        dataType: 'json',
        error: function () {
            $('#info').html('<p>Error fetching hero data (level)</p>');
        },
        success: function (data) {
            $("#level-data").attr("data-value", level);
            $(".hero-hp").text(data.computed.currentHp);
            $(".hero-mp").text(data.computed.currentMp);
            $(".hero-hp-regen").text(data.computed.currentHpRegen);
            $(".hero-mp-regen").text(data.computed.currentMpRegen);
            $(".hero-base-str").text(data.baseStr);
            $(".hero-str-gain").text(data.strGain);
            $(".hero-base-agi").text(data.baseAgi);
            $(".hero-agi-gain").text(data.agiGain);
            $(".hero-base-int").text(data.baseInt);
            $(".hero-int-gain").text(data.intGain);
            $(".hero-attack").text(data.computed.currentDmgMin + '-' + data.computed.currentDmgMax);
            $(".hero-armor").text(data.computed.currentArmor);
            $(".hero-armor-percent").text(data.computed.currentArmorPercent);
            $(".hero-ms").text(data.computed.currentMs);
        }
    });
});

$('.talent').click(function () {
    var heroId = $("#hero-data").attr("data-value");
    var heroLevel = $("#level-data").attr("data-value");
    var items = $("#items-data").attr("data-value");
    var neutralItem = $("#neutral-item-data").attr("data-value");
    $(this).toggleClass('active');
    var talents = '';
    $('.talent.active').each(function () {
        talents += $(this).attr("data-talentId") + ',';
    });
    talents = talents.slice(0, -1);
    $.ajax({
        type: 'GET',
        url: '/hero/' + heroId + '/data?level=' + heroLevel + '&talents=' + talents + '&items=' + items + '&neutral-item=' + neutralItem,
        dataType: 'json',
        error: function () {
            $('#info').html('<p>Error fetching talent data</p>');
        },
        success: function (data) {
            $("#talents-data").attr("data-value", talents);
            $(".hero-hp").text(data.computed.currentHp);
            $(".hero-mp").text(data.computed.currentMp);
            $(".hero-hp-regen").text(data.computed.currentHpRegen);
            $(".hero-mp-regen").text(data.computed.currentMpRegen);
            $(".hero-base-str").text(data.baseStr);
            $(".hero-str-gain").text(data.strGain);
            $(".hero-base-agi").text(data.baseAgi);
            $(".hero-agi-gain").text(data.agiGain);
            $(".hero-base-int").text(data.baseInt);
            $(".hero-int-gain").text(data.intGain);
            $(".hero-attack").text(data.computed.currentDmgMin + '-' + data.computed.currentDmgMax);
            $(".hero-armor").text(data.computed.currentArmor);
            $(".hero-armor-percent").text(data.computed.currentArmorPercent);
            $(".hero-ms").text(data.computed.currentMs);
        }
    });
});

$(".item").change(function () {
    var heroId = $("#hero-data").attr("data-value");
    var heroLevel = $("#level-data").attr("data-value");
    var talents = $("#talents-data").attr("data-value");
    var neutralItem = $("#neutral-item-data").attr("data-value");
    var items = '';
    $('.item').each(function () {
        if($(this).val()!=0) {
            items += $(this).val() + ',';
        }
    });
    items = items.slice(0, -1);
    $.ajax({
        type: 'GET',
        url: '/hero/' + heroId + '/data?level=' + heroLevel + '&talents=' + talents + '&items=' + items + '&neutral-item=' + neutralItem,
        dataType: 'json',
        error: function () {
            $('#info').html('<p>Error fetching item data</p>');
        },
        success: function (data) {
            $("#items-data").attr("data-value", items);
            $(".hero-hp").text(data.computed.currentHp);
            $(".hero-mp").text(data.computed.currentMp);
            $(".hero-hp-regen").text(data.computed.currentHpRegen);
            $(".hero-mp-regen").text(data.computed.currentMpRegen);
            $(".hero-base-str").text(data.baseStr);
            $(".hero-str-gain").text(data.strGain);
            $(".hero-base-agi").text(data.baseAgi);
            $(".hero-agi-gain").text(data.agiGain);
            $(".hero-base-int").text(data.baseInt);
            $(".hero-int-gain").text(data.intGain);
            $(".hero-attack").text(data.computed.currentDmgMin + '-' + data.computed.currentDmgMax);
            $(".hero-armor").text(data.computed.currentArmor);
            $(".hero-armor-percent").text(data.computed.currentArmorPercent);
            $(".hero-ms").text(data.computed.currentMs);
        }
    });

});

$("#neutral-item").change(function () {
    var heroId = $("#hero-data").attr("data-value");
    var heroLevel = $("#level-data").attr("data-value");
    var talents = $("#talents-data").attr("data-value");
    var items = $("#items-data").attr("data-value");
    var neutralItem = $(this).val();
    $.ajax({
        type: 'GET',
        url: '/hero/' + heroId + '/data?level=' + heroLevel + '&talents=' + talents + '&items=' + items + '&neutral-item=' + neutralItem,
        dataType: 'json',
        error: function () {
            $('#info').html('<p>Error fetching item data</p>');
        },
        success: function (data) {
            $("#neutral-item-data").attr("data-value", neutralItem);
            $(".hero-hp").text(data.computed.currentHp);
            $(".hero-mp").text(data.computed.currentMp);
            $(".hero-hp-regen").text(data.computed.currentHpRegen);
            $(".hero-mp-regen").text(data.computed.currentMpRegen);
            $(".hero-base-str").text(data.baseStr);
            $(".hero-str-gain").text(data.strGain);
            $(".hero-base-agi").text(data.baseAgi);
            $(".hero-agi-gain").text(data.agiGain);
            $(".hero-base-int").text(data.baseInt);
            $(".hero-int-gain").text(data.intGain);
            $(".hero-attack").text(data.computed.currentDmgMin + '-' + data.computed.currentDmgMax);
            $(".hero-armor").text(data.computed.currentArmor);
            $(".hero-armor-percent").text(data.computed.currentArmorPercent);
            $(".hero-ms").text(data.computed.currentMs);
        }
    });

});