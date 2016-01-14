;!function(){
	var loadingTimerId = null;
	var loadingTimerInterval = 200;
	var loadingTimerCount = 0;
	
	function loadingTimerCallback(){
		$('.loading>span').text('.....'.slice(0,-(loadingTimerCount--%5)));
		loadingTimerId = setTimeout(loadingTimerCallback, loadingTimerInterval);
	}
	
	window.addEventListener('DOMContentLoaded', function(eve){
		loadingTimerCallback();
		
		$(document).on('click', 'a.disabled', disabledLinkEvent);
		
		$.ajax({
			url: 'api.php',
			dataType: 'json',
		}).done(function(res){
			clearTimeout(loadingTimerId);
			
			if(res.status !== 'success'){
				$('.loading').text(res.message);
				return;
			}
			
			AjaxDoneCallback(res.data);
			
			$('.hidden')
				.removeClass('hidden')
				.addClass('beginFadeIn')
				.addClass('readyFadeIn');
			$('.loading').addClass('hidden');
		}).fail(function(err){
			clearTimeout(loadingTimerId);
			
			$('.loading').text('データの取得に失敗しました…');
		}).always(function(){
			// ツイートボタンの生成
			createTweetBtn();
		});
	},false);
	
	function AjaxDoneCallback(data){
		// ツイートボタンのパーセント表記の更新
		// ※jQueryの仕様によりネイティブDOMを使用 => https://w3g.jp/blog/jquery-data-attr-cache
		$('div.tweetBtn>a')[0].setAttribute('data-text','ごちうさ部ステータス 現在' + data.total_percent.toFixed(1) + '%');
		
		// グラフ表示
		$('section.graph .text').text(data.total_percent.toFixed(1) + '%');
		$('section.graph .fill').css('width', data.total_percent + '%');
		
		// メンバー表示
		var h = htmlSpecialChars();
		var members = data.members;
		var $fragment = $(document.createDocumentFragment())
		var names = {
			'chino': '香風智乃',
			'cocoa': '保登心愛',
			'rize': '天々座理世',
			'chiya': '宇治松千夜',
			'syaro': '桐間紗路',
			'maya': '条河麻耶',
			'megu': '奈津恵',
			'mocha': '保登モカ',
			'tippy': 'ティッピー',
		}
		var nameIds = Object.keys(names);
		
		$fragment.append(nameIds.map(function(name){
			var isExist    = !!members[name];
			var member     = members[name];
			var checkName  = (isExist && (member.is_hopping ? 'correct' : 'incorrect')) || 'notexist';
			var profileUri = (isExist && 'https://twitter.com/' + member.screen_name) || '#';
			var iconSrc    = (isExist && member.profile_image_url_https.replace(/_normal(\.(png|jpg))$/,'_200x200$1'))
				||
				('http://gochiusa.club/img/' + ((name==='megu') ? 'megumi' : name) + '.png');
			var charaName = names[name];
			var altName   = (isExist && h(member.name)) || charaName;
			var text      = (isExist && ('<a target="_blank" href="' + profileUri + '">@' + member.screen_name + '</a>&nbsp;は' + ((charaName===altName) ? (charaName + 'です。') : (charaName + 'ではありません。(' + altName + ')'))))
				||
				(charaName + 'はいません。');
			
			return $('<li></li>').addClass(name)
				.append($('<ul class="member"></ul>')
					.append($('<li class="check"></li>').addClass(checkName))
					.append($('<li class="icon"></li>')
						.append($('<a class="icon"></a>').attr({
								'href': profileUri,
								'target': (isExist) ? '_blank' : '_self',
							})
							.addClass(isExist ? '' : 'disabled')
							.append($('<img>').attr({
									'src': iconSrc,
									'alt': altName,
									'title': altName,
								}))))
					.append($('<li class="text"></li>').html(text))
				);
		}));
		
		$('.members').append($fragment);
	}
	
	function disabledLinkEvent(eve){
		return false;
	}
	
	function htmlSpecialChars(list){
		list = list || {
			'&': '&amp;',
			'\x27': '&#39;',
			'"': '&quot;',
			'<': '&lt;',
			'>': '&gt;'
		};
		var reg = new RegExp('['+Object.keys(list)+']','g');
		return function(str){
			return str.replace(reg, function($0){
				return list[$0];
			});
		}
	}
}();
