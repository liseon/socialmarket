<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 25.12.2014
 * Time: 23:39
 */

class Posts_SearcherCriteria
{
    /**
     * @var array ['ключ' => Баллы за вхождение]
     * За каждое вхождение ключа из этого массива будут начислены балы, но не более 1 раза за 1 слово
     */
    private $keys =[];

    /**
     * @var array [['keys' => ['key1', 'key2', ...], 'points' => Баллы за вхождение], ]
     * Можно загрузить неограниченое кол-во групп слов.
     * Баллы будут начислены за вхождение хотя бы одного слова из группы.
     * Баллы будут начислены только 1 раз.
     */
    private $groups = [];

    /** @var int За сколько дней искать */
    private $days;

    /** @var int Минимальный уровень баллов, чтобы считать сущность опознанной  */
    private $level;

    /** @var int Кол-во баллов, если все вхождения были обнаружены */
    private $maxPoints = 0;


    /**
     * @param array $keys
     * @param int $days
     * @param int $level
     */
    public function __construct(array $keys, $days = 30, $level = 100) {
        foreach ($keys as $key => $point) {
            $this->addKey($key, $point);
        }
        $this->days = (int)$days;
        $this->level = (int)$level;
    }

    public function addKey($key, $points) {
        $points = (int)$points;
        if (!$points > 0) {
            return false;
        }
        $key = Strings::normalize($key);
        $this->keys[$key] = $points;

        return true;
    }

    public function addGroup($group, $points) {
        $points = (int)$points;
        if (!$points > 0) {
            return false;
        }
        $groupNorm = [];
        foreach ($group as $val) {
            $groupNorm[] = Strings::normalize($val);
        }
        $this->groups[] = [
            'keys' => $groupNorm,
            'points' => $points,
        ];

        return true;
    }

    /**
     * Производит анализ текста
     * 1) Приводит текст к нормальному виду
     * 2) За каждое вхождение ключа начисляет соответствующее количество баллов.
     *    При этом количество вхождений одинакового ключа значения не имеет!
     * 3) Из всех групп ключей пытается найти хотя бы 1 вхождение для группы и начислить за это баллы
     * 4) Сравнивает результат с минимальным уровнем.
     *
     * @param $text
     * @return bool
     */
    public function analizeText($text) {
        $text = Strings::normalize($text);
        $result = 0;
        $match = [];
        foreach ($this->keys as $key => $point) {
            if (!mb_strpos($text, $key) === false) {
                $result += $point;
                $match[] = $key;
            }
        }
        foreach ($this->groups as $group) {
            $keys = $group['keys'];
            $points = $group['points'];
            foreach ($keys as $key) {
                if (!mb_strpos($text, $key) === false) {
                    $result += $points;
                    $match[] = $key;
                    break;
                }
            }
        }

        if (false && $result >= $this->level) {
            echo iconv('utf-8','cp866', $text) . "\n";
            echo "KEYS:: \n";
            foreach ($match as $m) {
                echo "  ==  " . iconv('utf-8','cp866', $m) . "\n";
            }

            echo "\n -------------------- \n";
        }

        return $result >= $this->level;
    }

    /**
     * @return int
     */
    public function getDays() {
        return $this->days;
    }

    /**
     * @return int
     */
    private function getMaxPoints() {
        if (!$this->maxPoints) {
            foreach ($this->keys as $point) {
                $this->maxPoints += $point;
            }
        }

        return $this->maxPoints;
    }





}