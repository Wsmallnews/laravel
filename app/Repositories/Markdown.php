<?php namespace App\Repositories;

use Parsedown;
use Purifier;
use League\HTMLToMarkdown\HtmlConverter;

class Markdown {

	public function markdownToHtml($markdown){
		$parsedown = new Parsedown();
		
		$html = $parsedown->setBreaksEnabled(true)->text($markdown);
		$html = Purifier::clean($html, 'user_topic_body');	// xss 过滤，脚本注入
		$html = str_replace("<pre><code>", '<pre><code class="language-php">', $html);
		return $html;
	}
	
	public function htmlToMarkdown($html){
		$htmlConverter = new HtmlConverter(['header_style' => 'atx']);
		
		return $htmlConverter->convert($html);
	}
}
