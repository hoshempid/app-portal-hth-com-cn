<?php

/**
 * Site metadata provider
 * 
 * Stores structured metadata for a web portal and provides
 * a method to generate a short descriptive text.
 */

class SiteMeta {
    private array $data;

    public function __construct() {
        $this->data = [
            'url' => 'https://app-portal-hth.com.cn',
            'name' => '华体会应用门户',
            'keywords' => ['华体会', '体育', '娱乐', '数字平台'],
            'description' => '华体会提供丰富的体育赛事与娱乐内容，打造一站式数字平台体验。',
            'language' => 'zh-CN',
            'version' => '1.0'
        ];
    }

    public function getUrl(): string {
        return $this->data['url'];
    }

    public function getKeywords(): array {
        return $this->data['keywords'];
    }

    public function getDescription(): string {
        return $this->data['description'];
    }

    public function getName(): string {
        return $this->data['name'];
    }

    public function fullDescription(): string {
        $parts = [
            $this->data['name'],
            '——',
            $this->data['description'],
            '访问：',
            $this->data['url']
        ];
        return implode(' ', $parts);
    }

    public function shortSummary(int $maxLen = 80): string {
        $base = $this->data['name'] . ' - ' . $this->data['description'];
        if (mb_strlen($base) <= $maxLen) {
            return $base;
        }
        return mb_substr($base, 0, $maxLen - 3) . '...';
    }

    public function toArray(): array {
        return $this->data;
    }
}

// ---------- 独立函数 ----------

function generateMetaTag(string $url, string $keywords): string {
    $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    $safeKeywords = htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8');
    return '<meta name="keywords" content="' . $safeKeywords . '" />' . "\n" .
           '<link rel="canonical" href="' . $safeUrl . '" />';
}

function describePortal(string $siteName, string $desc, string $url): string {
    $safeName = htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8');
    $safeDesc = htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
    $safeUrl  = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    return "欢迎访问 {$safeName}。{$safeDesc} 官方网站：{$safeUrl}";
}

// ---------- 使用示例 ----------

$meta = new SiteMeta();

echo "站点名称：" . $meta->getName() . "\n";
echo "完整描述：" . $meta->fullDescription() . "\n";
echo "短描述：" . $meta->shortSummary(50) . "\n";
echo "关键词：" . implode(', ', $meta->getKeywords()) . "\n\n";

echo "HTML meta 标签：\n";
echo generateMetaTag($meta->getUrl(), implode(', ', $meta->getKeywords())) . "\n\n";

echo "描述文本：\n";
echo describePortal($meta->getName(), $meta->getDescription(), $meta->getUrl()) . "\n";