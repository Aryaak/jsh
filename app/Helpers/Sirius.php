<?php

namespace App\Helpers;

use DateTime;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * All this helper created by Fathul Husnan under Code: Sirius.
 * www.fathulhusnan.com
 * www.codesirius.com
 *
 * Created At  : 2020
 * Last Updated: September 7, 2022
 */
class Sirius
{
    /**
     *	Convert number to Indonesian long day.
     *
     *   @param  int  $day day number that being converted.
     *   @param  string  $sunday M for Minggu, and A for Ahad.
     *   @return string ex: 1 => Senin
     **/
    public static function longDay(int $day, string $sunday = 'M'): string
    {
        if ($sunday == 'M') {
            $sunday = 'Minggu';
        } elseif ($sunday == 'A') {
            $sunday = 'Ahad';
        }

        $longDay = [
            0 => $sunday,
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => $sunday,
        ];

        return $longDay[$day];
    }

    /**
     *	Convert number to Indonesian long month.
     *
     *   @param  int  $month month number that being converted.
     *   @return string ex: 1 => Januari
     **/
    public static function longMonth(int $month): string
    {
        $longMonth = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $longMonth[$month];
    }

    /**
     *	Convert number to Indonesian short day.
     *
     *   @param  int  $day day number that being converted.
     *   @param  int  $length total length string.
     *   @param  string  $sunday M for Minggu, and A for Ahad.
     *   @return string ex: 1 => Sen
     **/
    public static function shortDay(int $day, int $length = 3, string $sunday = 'M'): string
    {
        if ($sunday == 'M') {
            $sunday = substr('Minggu', 0, $length);
        } elseif ($sunday == 'A') {
            $sunday = substr('Ahad', 0, $length);
        }

        $longDay = [
            0 => $sunday,
            1 => substr('Senin', 0, $length),
            2 => substr('Selasa', 0, $length),
            3 => substr('Rabu', 0, $length),
            4 => substr('Kamis', 0, $length),
            5 => substr('Jumat', 0, $length),
            6 => substr('Sabtu', 0, $length),
            7 => $sunday,
        ];

        return $longDay[$day];
    }

    /**
     *	Convert number to Indonesian sort month.
     *
     *   @param  int  $month month number that being converted.
     *   @param  int  $length total length string.
     *   @return string ex: 1 => Jan
     **/
    public static function shortMonth(int $month, int $length = 3): string
    {
        $shortMonth = [
            1 => substr('Januari', 0, $length),
            2 => substr('Februari', 0, $length),
            3 => substr('Maret', 0, $length),
            4 => substr('April', 0, $length),
            5 => substr('Mei', 0, $length),
            6 => substr('Juni', 0, $length),
            7 => substr('Juli', 0, $length),
            8 => substr('Agustus', 0, $length),
            9 => substr('September', 0, $length),
            10 => substr('Oktober', 0, $length),
            11 => substr('November', 0, $length),
            12 => substr('Desember', 0, $length),
        ];

        return $shortMonth[$month];
    }

    /**
     *	Convert date to Indonesian Long Date Format with day.
     *
     *   @param  string  $date the date that being converted.
     *   @param  string  $sunday M for Minggu, and A for Ahad.
     *   @return string ex: 2020-01-22 => Kamis, 22 Januari 2020
     **/
    public static function toLongDateDay(string $date, string $sunday = 'M'): string
    {
        $splited = str_split('0'.date('wdmy', strtotime($date)), 2);
        $dayText = self::longDay(intval($splited[0]), $sunday);
        $day = $splited[1];
        $month = self::longMonth(intval($splited[2]));
        $year = date('Y', strtotime($date));

        return "$dayText, $day $month $year";
    }

    /**
     *	Convert date to Indonesian Long Date Format with day and time.
     *
     *   @param  string  $date the date that being converted.
     *   @param  string  $sunday M for Minggu, and A for Ahad.
     *   @param  string  $separator separator between date and time.
     *   @param  bool  $timeFirst if true, the time will be on the front.
     *   @return string ex: 2020-01-22 16:00:00 => Kamis, 22 Januari 2020 16:00:00
     **/
    public static function toLongDateDayTime(string $date, string $sunday = 'M', string $separator = ' ', bool $timeFirst = false): string
    {
        if ($timeFirst) {
            return date('H:i:s', strtotime($date)).$separator.self::toLongDateDay($date, $sunday);
        }

        return self::toLongDateDay($date, $sunday).$separator.date('H:i:s', strtotime($date));
    }

    /**
     *	Convert date to Indonesian Long Date Format.
     *
     *   @param  string  $date the date that being converted.
     *   @return string ex: 2020-01-22 => 22 Januari 2020
     **/
    public static function toLongDate(string $date): string
    {
        $splited = str_split(date('dmy', strtotime($date)), 2);

        $day = $splited[0];
        $month = self::longMonth(intval($splited[1]));
        $year = date('Y', strtotime($date));

        return "$day $month $year";
    }

    /**
     *	Convert date to Indonesian Long Date Format with time.
     *
     *   @param  string  $date the date that being converted.
     *   @param  string  $separator separator between date and time.
     *   @param  bool  $timeFirst if true, the time will be on the front.
     *   @return string ex: 2020-01-22 16:00:00 => 22 Januari 2020 16:00:00
     **/
    public static function toLongDateTime(string $date, string $separator = ' ', bool $timeFirst = false): string
    {
        if ($timeFirst) {
            return date('H:i:s', strtotime($date)).$separator.self::toLongDate($date);
        }

        return self::toLongDate($date).$separator.date('H:i:s', strtotime($date));
    }

    /**
     *	Convert date to Indonesian Short Date Format with day
     *
     *   @param  string  $date the date that being converted.
     *   @param  int  $dayLength total length string for day.
     *   @param  int  $monthLength total length string for month.
     *   @param  string  $sunday M for Minggu, and A for Ahad.
     *   @return string ex: 2020-01-22 => Kam, 22 Jan 2020
     **/
    public static function toShortDateDay(string $date, int $dayLength = 3, int $monthLength = 3, string $sunday = 'M'): string
    {
        $splited = str_split('0'.date('wdmy', strtotime($date)), 2);

        $dayText = self::shortDay(intval($splited[0]), $dayLength, $sunday);
        $day = $splited[1];
        $month = self::shortMonth(intval($splited[2]), $monthLength);
        $year = date('Y', strtotime($date));

        return "$dayText, $day $month $year";
    }

    /**
     *	Convert date to Indonesian Short Date Format with day and time.
     *
     *   @param  string  $date the date that being converted.
     *   @param  int  $dayLength total length string for day.
     *   @param  int  $monthLength total length string for month.
     *   @param  string  $sunday M for Minggu, and A for Ahad.
     *   @param  string  $separator separator between date and time.
     *   @param  bool  $timeFirst if true, the time will be on the front.
     *   @return string ex: 2020-01-22 16:00:00 => Kam, 22 Jan 2020 16:00
     **/
    public static function toShortDateDayTime(string $date, int $dayLength = 3, int $monthLength = 3, string $sunday = 'M', string $separator = ' ', bool $timeFirst = false): string
    {
        if ($timeFirst) {
            return date('H:i', strtotime($date)).$separator.self::toShortDateDay($date, $dayLength, $monthLength, $sunday);
        }

        return self::toShortDateDay($date, $dayLength, $monthLength, $sunday).$separator.date('H:i', strtotime($date));
    }

    /**
     *	Convert date to Indonesian Short Date Format.
     *
     *   @param  string  $date the date that being converted.
     *   @param  int  $monthLength total month length string.
     *   @return string ex: 2020-01-22 => 22 Jan 2020
     **/
    public static function toShortDate(string $date, int $monthLength = 3): string
    {
        $splited = str_split(date('dmy', strtotime($date)), 2);

        $day = $splited[0];
        $month = self::shortMonth(intval($splited[1]), $monthLength);
        $year = date('Y', strtotime($date));

        return "$day $month $year";
    }

    /**
     *	Convert date to Indonesian Short Date Format with time.
     *
     *   @param  string  $date the date that being converted.
     *   @param  int  $monthLength total month length string.
     *   @param  string  $separator separator between date and time.
     *   @param  bool  $timeFirst if true, the time will be on the front.
     *   @return string ex: 2020-01-22 16:00:00 => 22 Jan 2020 16:00
     **/
    public static function toShortDateTime(string $date, int $dayLength = 3, int $monthLength = 3, string $sunday = 'M', string $separator = ' ', bool $timeFirst = false): string
    {
        if ($timeFirst) {
            return date('H:i', strtotime($date)).$separator.self::toShortDate($date, $monthLength);
        }

        return self::toShortDate($date, $monthLength).$separator.date('H:i', strtotime($date));
    }

    /**
     *	Convert time difference to Indonesian.
     *
     *	@param  string  $firstDate the first date (Y-m-d).
     *	@param  string  $secondDate the second date (Y-m-d).
     *  @param  bool  $withTime if you want the result return hour, minute, and second, set this to true (default: false)
     *   @return string ex result: 1 tahun 2 bulan 3 hari
     **/
    public static function timeDifference(string $firstDate, string $secondDate, bool $withTime = false): string
    {
        $date1 = new DateTime($firstDate);
        $date2 = new DateTime($secondDate);
        $interval = $date1->diff($date2);

        $return = $interval->y.' tahun '.$interval->m.' bulan, '.$interval->d.' hari';
        if ($withTime) {
            $return .= ' '.$interval->h.' jam '.$interval->i.' menit '.$interval->s.' detik ';
        }

        return $return;
    }

    /**
     *	Convert number to Indonesian Rupiah.
     *
     *	@param  float  $nominal the number that being converted.
     *	@param  int  $decimal set the number of decimal points.
     *   @return string ex: 10000 => Rp10.000,-
     **/
    public static function toRupiah(float $nominal, int $decimal = 0): string
    {
        $number = number_format(abs($nominal), intval($decimal), ',', '.').(($decimal == 0) ? ',-' : '');
        if ($nominal >= 0) {
            return "Rp$number";
        } else {
            return "- Rp$number";
        }
    }

    /**
     * Helper for function toRupiahInText
     *
     * @param  int  $nominal
     * @return string
     */
    private static function denominator(int $nominal): string
    {
        $nominal = abs($nominal);
        $oneToEleven = [
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas',
        ];

        $text = '';
        if ($nominal < 12) {
            $text = ' '.$oneToEleven[$nominal];
        } elseif ($nominal < 20) {
            $text = self::denominator($nominal - 10).' belas';
        } elseif ($nominal < 100) {
            $text = self::denominator($nominal / 10).' puluh'.self::denominator($nominal % 10);
        } elseif ($nominal < 200) {
            $text = ' seratus'.self::denominator($nominal - 100);
        } elseif ($nominal < 1000) {
            $text = self::denominator($nominal / 100).' ratus'.self::denominator($nominal % 100);
        } elseif ($nominal < 2000) {
            $text = ' seribu'.self::denominator($nominal - 1000);
        } elseif ($nominal < 1000000) {
            $text = self::denominator($nominal / 1000).' ribu'.self::denominator($nominal % 1000);
        } elseif ($nominal < 1000000000) {
            $text = self::denominator($nominal / 1000000).' juta'.self::denominator($nominal % 1000000);
        } elseif ($nominal < 1000000000000) {
            $text = self::denominator($nominal / 1000000000).' milyar'.self::denominator(fmod($nominal, 1000000000));
        } elseif ($nominal < 1000000000000000) {
            $text = self::denominator($nominal / 1000000000000).' trilyun'.self::denominator(fmod($nominal, 1000000000000));
        }

        return $text;
    }

    /**
     *	Convert number to Indonesian Rupiah in text (terbilang).
     *
     *	@param  int  $nominal the number that being converted.
     *  @return string ex: 10000 => sepuluh ribu rupiah
     **/
    public static function toRupiahInText(int $nominal): string
    {
        $text = '';
        if ($nominal < 0) {
            $text = 'minus '.trim(self::denominator($nominal));
        } else {
            $text = trim(self::denominator($nominal));
        }

        $text = str_replace('  ', ' ', $text);
        $text .= ' rupiah';

        if ($text == ' rupiah') {
            $text = 'nol rupiah';
        }

        return $text;
    }

    /**
     * Convert number to shorter form
     *
     * @param  int  $nominal the number that being converted.
     * @return string ex: 1000 => 1rb
     */
    public static function toShortNominal(int $nominal): string
    {
        $division = match (true) {
            strlen($nominal) - 1 >= 6 => 1000000,
            strlen($nominal) - 1 >= 3 => 1000,
            default => 1,
        };

        $text = match ($division) {
            1000000 => 'jt',
            1000 => 'rb',
            default => '  ',
        };

        return floor($nominal / $division).$text;
    }

    /**
     * Remove 0, Indonesia's phone code number (+62), space, dash, and/or dot from the string
     *
     * @param  string  $number the number that being converted.
     * @return string ex: +62 823-3049-5179 => 82330495179
     */
    public static function sanitizePhoneNumber(string $number): string
    {
        $phone = Str::replace('-', '', Str::replace('.', '', Str::replace('+62', '', $number)));
        $phone = $phone[0] == 0 ? Str::replaceFirst('0', '', $phone) : $phone;

        return $phone;
    }

    /**
     * Get all province in Indonesia.
     *
     * @return array
     */
    public static function getAllProvince(): array
    {
        return [
            'Aceh',
            'Bali',
            'Banten',
            'Bengkulu',
            'Daerah Istimewa Yogyakarta',
            'Daerah Khusus Ibukota Jakarta',
            'Gorontalo',
            'Jambi',
            'Jawa Barat',
            'Jawa Tengah',
            'Jawa Timur',
            'Kalimantan Barat',
            'Kalimantan Selatan',
            'Kalimantan Tengah',
            'Kalimantan Timur',
            'Kalimantan Utara',
            'Kepulauan Bangka Belitung',
            'Kepulauan Riau',
            'Lampung',
            'Maluku',
            'Maluku Utara',
            'Nusa Tenggara Barat',
            'Nusa Tenggara Timur',
            'Papua',
            'Papua Barat',
            'Papua Pegunungan',
            'Papua Selatan',
            'Papua Tengah',
            'Riau',
            'Sulawesi Barat',
            'Sulawesi Selatan',
            'Sulawesi Tengah',
            'Sulawesi Tenggara',
            'Sulawesi Utara',
            'Sumatra Barat',
            'Sumatra Selatan',
            'Sumatra Utara',
        ];
    }

    /**
     * Generate random string.
     *
     * @param  int  $length length of string
     * @param  bool  $withNumber is the random string accept number?
     * @param  bool  $withSymbol is the random string accept symbol?
     * @return string
     */
    public static function randomString(int $length, bool $withNumber = true, bool $withSymbol = true): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($withNumber == true) {
            $characters .= '0123456789';
        }
        if ($withSymbol == true) {
            $characters .= '~!@#$%^&*()_+[]{},.<>?';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Get random lorem ipsum text in sentance.
     *
     * @param  int  $maxWord maximum word will be retrived, insert 0 for unlimited (default = 0)
     * @return string
     */
    public static function randomLoremIpsumSentance(int $maxWord = 0): string
    {
        $text = [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'Suspendisse sed ex ultricies, feugiat velit ac, lacinia augue.',
            'Donec sit amet neque vehicula, bibendum metus at, efficitur nisl.',
            'Donec convallis elit ut metus rutrum, at gravida lorem finibus.',
            'Aenean consectetur leo ut metus hendrerit, ut eleifend erat mattis.',
            'Duis ut augue interdum, semper augue a, tristique libero.',
            'Duis dictum enim sit amet velit rutrum, at fringilla libero scelerisque.',
            'Ut et risus ac magna commodo hendrerit.',
            'Nam et arcu eu lorem consequat posuere eu nec libero.',
            'Aliquam vitae sem eget justo eleifend molestie quis vitae enim.',
            'Aenean in mi at diam condimentum tincidunt.',
            'Nam ullamcorper ligula non nibh consectetur commodo.',
            'Praesent posuere tortor pellentesque, consequat sapien nec, fringilla justo.',
            'Nam commodo ex eu convallis lobortis.',
            'Fusce sed tortor placerat ex pharetra ornare ut in ante.',
            'Cras ut est nec velit mattis viverra.',
            'Suspendisse in ligula non metus efficitur tempor.',
            'Mauris eu velit sed nulla euismod placerat.',
            'Integer a dui vel magna euismod tempor.',
            'Donec eget sapien sit amet quam tincidunt vulputate.',
            'Maecenas suscipit sem eget blandit suscipit.',
            'Fusce ut nibh at nisi posuere dignissim vitae nec libero.',
            'Curabitur semper augue id dolor vulputate, et scelerisque sem luctus.',
            'Aliquam pharetra risus vel egestas hendrerit.',
            'Cras at libero tristique ex efficitur pulvinar.',
            'Suspendisse porta nulla eu orci mattis vulputate.',
            'Vestibulum faucibus nulla at est pharetra aliquet.',
            'Curabitur eu odio id mi rutrum sodales.',
            'Cras quis mi tincidunt, viverra mauris non, blandit libero.',
            'In pretium libero quis ipsum commodo, ac dignissim ex dictum.',
            'Sed sagittis urna a est scelerisque vulputate.',
            'Vestibulum ut quam sit amet mauris laoreet mattis ut id nunc.',
            'Phasellus id sapien ut ante vulputate ultricies non vitae nisi.',
            'Quisque et urna ut enim condimentum sagittis ut nec arcu.',
            'Etiam molestie magna id nulla convallis, sed aliquet diam volutpat.',
            'Morbi sit amet nunc ac libero semper varius.',
            'In vitae risus ac odio lobortis varius non ac dui.',
            'Nam ut est nec tellus auctor pellentesque.',
            'Vivamus non eros ac tortor pellentesque laoreet eget eu nulla.',
            'Donec ac lorem nec nulla tristique varius.',
            'Ut venenatis nunc faucibus tristique venenatis.',
            'Donec interdum nisi et sem rutrum scelerisque.',
            'Vivamus non dui aliquet arcu finibus blandit.',
            'Sed sed ante sed nisi mollis interdum id eu nisi.',
            'Pellentesque scelerisque arcu ac augue porta vehicula.',
            'Sed eget nulla tempus, congue ligula id, elementum tellus.',
            'Etiam semper est a massa porta, ut lobortis lectus aliquet.',
            'Donec efficitur nunc at nunc bibendum, quis rhoncus est feugiat.',
            'Phasellus vel elit at lacus tincidunt sollicitudin quis ac mi.',
            'Sed imperdiet nisl eget nisl ornare luctus.',
            'Sed sed lectus ut ante interdum ultricies nec ac eros.',
            'Mauris semper mauris ac erat scelerisque lobortis.',
            'Ut faucibus nunc non ligula euismod lacinia.',
            'Mauris semper metus quis facilisis rhoncus.',
            'Donec rutrum elit vitae pellentesque rutrum.',
            'Proin dictum justo ut augue dignissim porta.',
            'Fusce ornare magna id ultrices fringilla.',
            'Aenean pulvinar odio quis euismod mattis.',
            'Integer sit amet nisi ut nisl congue sodales tincidunt ut lacus.',
            'Nunc sit amet purus pharetra nulla semper iaculis ut a metus.',
            'Nam vehicula augue non risus aliquam placerat.',
            'Mauris et felis sed eros euismod dapibus at non ipsum.',
            'Nunc maximus nunc in fringilla blandit.',
            'Sed consequat dui vel ornare consequat.',
            'Sed a est pulvinar, pellentesque odio at, finibus lectus.',
            'Vivamus eget nibh at tellus elementum vestibulum at et nisi.',
            'Ut non ligula id tellus convallis sagittis.',
            'Cras eu lorem ac magna dignissim pulvinar.',
            'Sed facilisis ex vel nibh euismod, consectetur rutrum erat porta.',
            'Aenean pretium ipsum id nisi dictum, pharetra malesuada elit varius.',
            'In suscipit augue quis elit rhoncus laoreet.',
            'Integer congue dui quis felis dictum, in vehicula turpis molestie.',
            'Praesent scelerisque libero sed ligula facilisis maximus.',
            'Proin eu dui quis libero ultrices vestibulum aliquam nec quam.',
            'Fusce pharetra arcu id mattis bibendum.',
            'In in orci et urna consectetur auctor at a odio.',
            'Nunc sed nisl sed lacus rhoncus scelerisque sit amet id enim.',
            'Integer tincidunt orci quis turpis tincidunt volutpat.',
            'Suspendisse quis ante eleifend, aliquet massa id, consectetur sem.',
            'Praesent nec diam tempor quam ornare ultrices.',
            'Pellentesque ac velit non urna faucibus tincidunt.',
            'Aenean ornare augue sed tortor tincidunt, non euismod ex vestibulum.',
            'Sed sit amet lorem euismod, accumsan risus in, pulvinar nunc.',
            'Phasellus aliquam diam tempor vehicula bibendum.',
            'Cras vitae mi aliquam, consequat mauris nec, pharetra ante.',
            'Proin facilisis arcu laoreet arcu tincidunt, sed suscipit velit elementum.',
            'Nullam posuere turpis a dui tristique elementum.',
            'Integer ut nisi eget nisl tristique tincidunt.',
            'Praesent vel lorem vel nulla viverra ultrices at et nulla.',
            'Integer ultricies ipsum eget orci semper vehicula.',
            'Nam placerat nisi id augue rutrum, nec iaculis neque condimentum.',
            'Donec ullamcorper arcu at varius hendrerit.',
            'Ut sed ex quis eros suscipit scelerisque.',
            'Sed congue sapien non elementum bibendum.',
            'Donec porta tellus sit amet quam bibendum, id tincidunt dolor iaculis.',
            'In sollicitudin sapien sed leo ornare sollicitudin.',
            'Nulla molestie arcu in viverra elementum.',
            'Nulla a orci non erat sagittis porttitor.',
            'Aliquam vestibulum nulla in lacus condimentum, sit amet interdum augue mattis.',
            'Cras tristique odio id odio tempor, quis placerat odio fermentum.',
            'Mauris eget ligula quis metus cursus finibus.',
            'Cras ac risus efficitur, elementum quam ut, pellentesque erat.',
            'Aenean malesuada eros a lacinia dignissim.',
            'Suspendisse ac ipsum vel tellus venenatis lobortis.',
            'Sed efficitur risus et arcu faucibus, non efficitur erat auctor.',
            'Morbi ac quam bibendum risus convallis sollicitudin ac quis diam.',
            'Sed consectetur velit et blandit eleifend.',
            'Donec commodo libero vel ligula tempus sollicitudin.',
            'Aenean eget nulla gravida, venenatis velit sed, tincidunt felis.',
            'Cras dapibus augue eu ipsum tempor facilisis.',
            'Aenean aliquet ipsum eu ipsum mollis, sed pulvinar leo malesuada.',
            'Pellentesque vel leo sed ligula fringilla vehicula et eu nulla.',
            'In interdum massa nec mi euismod, eu posuere lectus porttitor.',
            'Maecenas eget mi tincidunt augue vulputate posuere in nec elit.',
            'Quisque scelerisque elit et metus aliquet vestibulum.',
            'Phasellus blandit sem id commodo luctus.',
            'Morbi et neque sit amet felis sagittis tristique.',
            'Praesent ornare velit et venenatis fermentum.',
            'Fusce et urna placerat, gravida justo eu, ullamcorper neque.',
            'Nullam cursus mi non dolor varius, ut ultrices nunc mattis.',
            'Proin condimentum dui ac neque efficitur finibus.',
            'Proin a odio sit amet tortor posuere cursus.',
            'Nunc quis enim dapibus, pharetra sapien pellentesque, congue justo.',
            'Integer facilisis ipsum eget lacus volutpat fringilla.',
            'Maecenas pharetra diam nec dolor luctus pellentesque.',
            'Phasellus ac ipsum in turpis pretium rhoncus.',
            'Nulla sodales eros ut nisl laoreet mattis.',
            'Cras eget ex non velit consequat euismod.',
            'Nunc non diam quis odio imperdiet posuere.',
            'Aliquam nec tellus sagittis est pharetra cursus.',
            'Fusce ultricies orci eget ligula pharetra lobortis.',
            'Nunc auctor risus eu venenatis dignissim.',
            'Aenean convallis ligula sit amet vulputate vestibulum.',
            'In placerat elit a semper volutpat.',
            'Phasellus id est at odio ornare maximus.',
            'Aliquam vel augue id turpis suscipit laoreet eget nec tellus.',
            'Vivamus placerat turpis vel congue sagittis.',
            'Donec ac dui vitae massa lobortis scelerisque nec eget enim.',
            'Cras lobortis turpis sit amet lorem tempor faucibus vel eget ante.',
            'Sed ac augue sed dui lacinia vehicula vitae non felis.',
            'Aliquam sodales justo sed rutrum porttitor.',
            'Quisque auctor felis nec tortor porta faucibus.',
            'Vestibulum feugiat magna vitae risus aliquam consequat.',
            'Praesent ut turpis sed lectus vestibulum laoreet.',
            'Nulla ac lorem at ex mattis porttitor.',
            'Donec id ex eu eros fringilla vulputate.',
            'Cras commodo tellus at massa sagittis vulputate.',
            'Nunc et ligula vitae urna malesuada elementum.',
            'In volutpat tortor et quam hendrerit porta.',
            'Suspendisse vestibulum dolor non dolor rutrum tincidunt vitae id diam.',
            'Integer laoreet purus ut nisl elementum congue.',
            'Donec egestas leo non porttitor scelerisque.',
            'Vestibulum auctor urna eget tincidunt mattis.',
            'Pellentesque rutrum arcu in imperdiet interdum.',
            'Aenean eu felis nec lacus cursus porttitor nec eu sem.',
            'Vivamus ut neque eu sem fringilla convallis eu quis nisl.',
            'Curabitur non nunc quis nisl vulputate posuere.',
            'Suspendisse interdum tellus finibus felis congue pulvinar.',
            'Donec eu justo pharetra, ultricies metus sed, eleifend neque.',
            'Duis pellentesque quam nec metus fringilla, et vulputate metus consectetur.',
            'Nulla eget lacus at orci congue dignissim.',
            'Etiam eget erat placerat, ultricies nisl vitae, dictum ligula.',
            'Aliquam sit amet elit eleifend, maximus mauris eu, laoreet ipsum.',
            'Quisque rhoncus nisl nec egestas egestas.',
            'Fusce mollis metus euismod urna aliquam, eu consectetur elit fermentum.',
            'Aenean eget nunc in lorem sodales mattis in in turpis.',
            'Fusce aliquet orci sed turpis tempus efficitur.',
            'Curabitur a magna sollicitudin, sagittis tortor eget, laoreet leo.',
            'Etiam interdum quam in velit elementum, nec consectetur dolor dignissim.',
            'Aliquam quis magna sed nibh tempor aliquet ac in lorem.',
            'Proin dictum lacus malesuada, hendrerit ligula quis, porta ex.',
            'Aenean vitae augue eleifend leo varius rutrum.',
            'Nunc eget leo ac sapien consequat efficitur a sed diam.',
            'Donec dignissim est sed sem auctor, quis ultricies sapien eleifend.',
            'Cras vitae enim ut elit maximus placerat.',
            'Vestibulum ut sapien dignissim, dapibus libero ac, iaculis eros.',
            'Curabitur at risus auctor, tristique enim quis, vehicula quam.',
            'Maecenas a sapien at justo convallis efficitur.',
            'Duis dapibus nisi ut justo dapibus, nec laoreet nisl sagittis.',
            'Suspendisse vel metus placerat, commodo nulla eget, lacinia odio.',
            'Donec posuere elit dictum lacus cursus, vel eleifend odio viverra.',
            'Donec maximus sem nec velit consectetur mollis.',
            'Aliquam auctor nibh aliquet elit luctus, et luctus urna viverra.',
            'Mauris ac lorem elementum, dignissim purus eu, dignissim nunc.',
            'Integer placerat massa id mollis scelerisque.',
            'Donec interdum neque non nibh lobortis eleifend.',
            'Aenean pellentesque orci non metus vehicula, ac euismod purus pretium.',
            'Donec dapibus lorem vitae placerat volutpat.',
            'In eget massa non urna iaculis suscipit.',
            'Morbi quis libero a urna sollicitudin cursus vel quis mi.',
            'Cras cursus felis laoreet blandit bibendum.',
            'Vivamus ut purus rhoncus, consectetur nunc vel, facilisis arcu.',
            'Integer dapibus leo sed enim blandit tristique.',
            'Nullam vel nibh pretium, tincidunt ligula ut, ornare sem.',
            'Nunc iaculis augue vel enim convallis viverra.',
            'Nam bibendum enim quis sem scelerisque, a venenatis nisi dignissim.',
            'Sed dignissim erat quis convallis vulputate.',
            'Fusce et diam vitae diam ultricies lobortis.',
            'In porta est nec posuere molestie.',
            'Nunc vitae nulla laoreet, vulputate purus vitae, rutrum nisi.',
            'Fusce vel enim vitae neque elementum mattis non eget quam.',
            'Nullam blandit urna ut libero pharetra rutrum.',
            'Aenean venenatis quam vel nulla malesuada, sit amet auctor ligula laoreet.',
            'Suspendisse hendrerit lorem non purus eleifend tempus.',
            'Morbi consequat ligula aliquet vulputate aliquet.',
            'Sed pretium sapien in nibh maximus, ac venenatis augue molestie.',
            'Praesent vel eros suscipit, blandit mauris non, pharetra odio.',
            'Integer placerat elit aliquam egestas semper.',
            'Nunc tristique ligula nec sagittis aliquet.',
            'Aliquam sed ligula rhoncus, placerat leo condimentum, placerat magna.',
            'Vivamus et massa lacinia, vehicula nisi vel, condimentum ex.',
            'Cras interdum orci gravida mauris finibus sodales.',
            'Vestibulum sollicitudin magna at sagittis aliquet.',
            'Phasellus convallis augue vel viverra lobortis.',
            'Morbi semper mi sed hendrerit mattis.',
            'Aliquam a neque volutpat, porta neque eu, tempor libero.',
            'In tempus dolor sed tristique tempor.',
            'Praesent aliquet nisi vulputate nulla bibendum, et elementum mauris ullamcorper.',
            'Pellentesque volutpat nibh sit amet neque sagittis, id tempor lacus maximus.',
            'Aenean cursus turpis nec porta molestie.',
            'Integer quis turpis viverra, dapibus mi in, condimentum lorem.',
            'Ut eu enim quis quam ultrices porta sed eget risus.',
            'Phasellus tempus metus eget ligula ultrices, ac volutpat tellus varius.',
            'Proin ac magna nec lacus posuere mollis.',
            'Maecenas in mauris molestie urna finibus commodo.',
            'Nulla congue felis varius, tincidunt purus eu, aliquam lacus.',
            'Quisque et leo sit amet justo finibus tempus.',
            'Phasellus vel ante varius, maximus mi vel, maximus nunc.',
            'Integer ac lorem et neque vehicula varius.',
            'Nullam bibendum leo et posuere porttitor.',
            'Nunc varius odio in auctor ullamcorper.',
            'In id odio at mi imperdiet posuere.',
            'Duis hendrerit erat a lobortis ullamcorper.',
            'Praesent tempus nunc id lacus cursus faucibus.',
            'Cras hendrerit justo a tellus condimentum consectetur.',
            'Morbi et ligula imperdiet, ullamcorper libero nec, dapibus dui.',
            'Aliquam quis elit et nulla sodales luctus.',
            'Proin ultrices turpis sed molestie fermentum.',
            'Phasellus rhoncus ligula at rhoncus pharetra.',
            'Curabitur porta dui et feugiat imperdiet.',
            'Sed elementum dolor a tempus pellentesque.',
            'Etiam ut sapien volutpat, molestie leo blandit, commodo dui.',
            'Etiam sit amet quam et ex mattis sodales.',
            'In pellentesque lacus feugiat nisi bibendum, non aliquam augue porttitor.',
            'Fusce varius tortor vel iaculis sollicitudin.',
            'Duis tempus dolor vitae nisl rhoncus, nec vehicula magna faucibus.',
            'Aliquam at odio egestas, mollis erat vel, efficitur tellus.',
            'Suspendisse ac justo condimentum, fermentum nulla ut, pharetra ligula.',
            'Aenean tincidunt tortor sed facilisis elementum.',
            'Aenean sit amet elit nec arcu euismod vestibulum.',
            'Duis pellentesque felis eget est euismod pulvinar.',
            'Cras pulvinar augue ac nulla vehicula, euismod rhoncus orci mattis.',
            'Praesent mollis felis vitae ornare commodo.',
            'Cras non orci ac ipsum dapibus porttitor.',
            'Donec eu arcu eu lacus dignissim lobortis sit amet id velit.',
            'Sed at turpis gravida, ullamcorper urna nec, consequat arcu.',
            'Morbi pellentesque justo at tristique sagittis.',
            'Nam luctus nibh non pulvinar ultrices.',
            'Fusce et tellus eget libero malesuada interdum ac quis lacus.',
            'Integer dictum dolor eu fermentum mattis.',
            'Sed mollis nisi eget tincidunt facilisis.',
            'Sed vitae ante aliquam, consequat felis nec, vestibulum est.',
            'Ut eu diam ut magna varius blandit.',
            'In semper tellus eget maximus scelerisque.',
            'Fusce condimentum massa ut tellus consectetur porttitor.',
            'Suspendisse elementum elit vitae tortor porta dictum.',
            'Nam id urna auctor, rhoncus ante sed, mollis ex.',
            'Duis et dolor dictum, finibus odio sed, vestibulum enim.',
            'Fusce ullamcorper erat eu risus laoreet, a posuere sem ullamcorper.',
            'Aenean nec ligula tincidunt, sagittis enim a, dignissim nisl.',
            'Ut vitae libero vitae libero interdum tristique id non metus.',
            'Phasellus luctus urna vitae ultrices pretium.',
            'Suspendisse rhoncus tortor ac pretium facilisis.',
            'Fusce sagittis neque ac mattis varius.',
            'Donec rhoncus tellus at viverra sollicitudin.',
            'Curabitur luctus erat nec augue sodales, eget condimentum arcu varius.',
            'Pellentesque dignissim eros in condimentum dignissim.',
            'Nunc mattis ipsum ac elit viverra, eget faucibus est molestie.',
            'Aenean et felis eleifend purus congue efficitur eget id diam.',
            'Morbi varius felis eu malesuada tristique.',
            'Maecenas ornare erat et mauris consectetur condimentum.',
            'Sed sit amet enim hendrerit, faucibus velit sit amet, vehicula velit.',
            'Integer et metus quis lacus tempus pharetra in quis leo.',
            'Maecenas bibendum metus vitae mauris vulputate, eget ullamcorper dolor mattis.',
            'Nulla a ex gravida, pulvinar ipsum sed, aliquam ligula.',
            'Morbi id elit vitae lectus placerat fermentum eu nec est.',
            'Vestibulum ut metus non est luctus accumsan.',
            'Sed semper dui fermentum tempus efficitur.',
            'Ut eget felis et sapien pellentesque lobortis.',
            'Integer vehicula ante a vestibulum interdum.',
            'Pellentesque tempor sem vel orci elementum, dapibus blandit ex accumsan.',
            'Curabitur nec augue interdum, consequat turpis id, porttitor massa.',
            'Vivamus finibus risus eget orci finibus scelerisque.',
            'In interdum felis eu libero tincidunt, viverra mattis nunc fringilla.',
            'Sed eget leo a augue dapibus ullamcorper et vel velit.',
            'Nam mollis tortor porta elementum porttitor.',
            'Sed et nisi tempus, egestas orci in, viverra velit.',
            'Etiam nec elit eget tellus egestas congue.',
            'In ac urna in nulla tincidunt iaculis.',
            'Vestibulum auctor enim nec orci convallis elementum.',
            'Curabitur tincidunt nibh et mi viverra euismod.',
            'Fusce vitae nibh mattis, aliquam orci sed, iaculis massa.',
            'Duis a neque ultricies, commodo nibh non, convallis elit.',
            'Cras consectetur ipsum posuere dictum consequat.',
            'Etiam eget eros faucibus, ultricies leo nec, posuere odio.',
            'Aliquam nec eros et lorem venenatis mollis quis ultrices justo.',
            'Nam et neque sed erat sollicitudin dignissim a vel velit.',
            'Donec ultrices elit sed iaculis placerat.',
            'Ut cursus eros non metus scelerisque efficitur.',
            'Praesent id dui vestibulum, sagittis justo sit amet, blandit diam.',
            'Proin semper sapien in ligula posuere, id finibus risus ultrices.',
            'Ut et dui non metus luctus convallis.',
            'Nullam congue erat eget sodales placerat.',
            'Mauris id ligula elementum, ultrices leo in, ullamcorper urna.',
            'Maecenas vel leo eleifend, posuere massa ut, egestas elit.',
            'Etiam eu quam blandit, fermentum risus vel, scelerisque justo.',
            'Sed scelerisque erat in auctor vulputate.',
            'Vivamus eu est sed risus pretium dignissim.',
            'Donec ac quam vel mauris pulvinar molestie.',
            'Ut eu elit venenatis diam interdum luctus.',
            'Sed posuere ante vitae gravida tempor.',
            'Donec pretium lectus ac metus pellentesque, vitae elementum orci lobortis.',
            'Aliquam eget ligula ut enim tincidunt molestie rutrum nec ex.',
            'Donec faucibus risus quis consequat pellentesque.',
            'Curabitur eu ante ultricies, viverra libero sit amet, tempus felis.',
            'Proin iaculis tortor in sodales tempus.',
            'Proin vel tellus ac sem tincidunt varius.',
            'Pellentesque rhoncus massa vel dignissim mollis.',
            'Praesent porta ipsum imperdiet rutrum efficitur.',
            'Aenean fermentum lectus non convallis vestibulum.',
            'Vestibulum vel sem sed lacus aliquet rhoncus vel non nulla.',
            'Curabitur ut neque at dolor lobortis mollis.',
            'Integer fermentum purus vitae luctus porta.',
            'Morbi mattis ex in lorem iaculis ultricies.',
            'Vestibulum tincidunt velit non quam bibendum posuere non sit amet ex.',
            'Donec porta sem et sem tincidunt eleifend.',
            'Donec vel lectus a odio fringilla mattis.',
            'In molestie purus a lorem eleifend semper.',
            'Vestibulum in lectus eget libero pulvinar laoreet non quis felis.',
            'Morbi lacinia lorem quis placerat laoreet.',
            'Mauris aliquam sem non ex gravida, sit amet interdum lorem feugiat.',
            'Duis sit amet ligula non nisi commodo maximus.',
            'In nec leo non sapien hendrerit fermentum et at sapien.',
            'Aliquam in purus eget nisl viverra tempor.',
            'Donec auctor sem at mi facilisis, a suscipit velit congue.',
            'Integer vel sem quis odio mollis tempus ac et elit.',
            'Fusce porttitor augue et diam gravida, eget gravida magna lacinia.',
            'Etiam sed nibh ut nulla laoreet congue.',
            'Sed consequat lorem et orci pulvinar, eu luctus ex sagittis.',
            'Duis eget dolor a nisl volutpat pellentesque ac ac odio.',
            'Nam ut nisi vel nisi varius commodo.',
            'Suspendisse ut justo in purus maximus scelerisque vel ut lectus.',
            'Pellentesque placerat magna consequat, tristique metus eget, blandit purus.',
            'Nunc feugiat quam quis elementum laoreet.',
            'Vivamus malesuada purus vitae vehicula tempor.',
        ];

        $text = $text[mt_rand(0, count($text) - 1)];

        if ($maxWord != 0) {
            $splited = explode(' ', $text, $maxWord + 1);
            $text = '';
            for ($i = 0; $i < count($splited) - 1; $i++) {
                $text .= $splited[$i];
                if ($i < $maxWord - 1) {
                    $text .= ' ';
                }
            }
        }

        return $text;
    }

    /**
     * Get initials from text
     *
     * @param  string  $text
     * @param  int  $length 0 means all (default: 2)
     * @return string
     */
    public static function getInitials(string $text, int $length = 2): string
    {
        if ($length > 0) {
            $text = explode(' ', $text, $length);
        } else {
            $text = explode(' ', $text);
        }

        $initials = '';
        foreach ($text as $word) {
            $initials .= $word[0];
        }

        if ($length > 0) {
            $letters = str_split($word);
            $index = 1;
            while (strlen($initials) < $length) {
                $initials .= ($letters[$index] ?? ' ');
                $index++;
            }
        }

        return strtoupper($initials);
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     *
     * @param  float  $latitudeFrom Latitude of start point in [deg decimal]
     * @param  float  $longitudeFrom Longitude of start point in [deg decimal]
     * @param  float  $latitudeTo Latitude of target point in [deg decimal]
     * @param  float  $longitudeTo Longitude of target point in [deg decimal]
     * @param  float  $earthRadius Mean earth radius in [m]
     * @return float  Distance between points in [m] (same as earthRadius)
     */
    public static function calculateDistance(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo, float $earthRadius = 6371000): float
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    /**
     * Encrypt string using AES-256 method
     *
     * @param  string  $plaintext text you want to encrypt
     * @param  ?string  $salt key for encrypting the text (must be the same as key for decrypt)
     * @return string ex: fathul => 1XWdH7LwRYXxlhJRO1enww==
     */
    public static function encrypt(string $plaintext, ?string $salt = null): string
    {
        $salt = $salt ?? config('app.key');
        $method = 'aes-256-cbc';
        $key = substr(hash('sha256', $salt, true), 0, 32);
        $iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);

        return Str::of(base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv)));
    }

    /**
     * Decrypt the encrypted string using AES-256 method
     *
     * @param  string  $chipertext the encrypted text
     * @param  ?string  $salt key for decrypting te text
     * @return string ex: 1XWdH7LwRYXxlhJRO1enww== => fathul
     */
    public static function decrypt(string $chipertext, ?string $salt = null): string
    {
        $salt = $salt ?? config('app.key');
        $method = 'aes-256-cbc';
        $key = substr(hash('sha256', $salt, true), 0, 32);
        $iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);

        return openssl_decrypt(base64_decode($chipertext), $method, $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * Encrypt string using AES-256 method (friendly for url)
     *
     * @param  string  $plaintext text you want to encrypt
     * @param  ?string  $salt key for encrypting the text (must be the same as key for decrypt)
     * @return string ex: fathul => 1XWdH7LwRYXxlhJRO1enww--
     */
    public static function encryptUrlSafe(string $plaintext, ?string $salt = null): string
    {
        return Str::of(strtr(self::encrypt($plaintext, $salt), '+/=', '._-'));
    }

    /**
     * Decrypt the encrypted string using AES-256 method that url friendly
     *
     * @param  string  $chipertext the encrypted text
     * @param  ?string  $salt key for decrypting te text
     * @return string ex: 1XWdH7LwRYXxlhJRO1enww-- => fathul
     */
    public static function decryptUrlSafe(string $chipertext, ?string $salt = null): string
    {
        return self::decrypt(strtr($chipertext, '._-', '+/='), $salt);
    }

    /**
     * Get Metronic's SVG icon.
     * Icon list: https://preview.keenthemes.com/metronic8/demo1/documentation/icons/duotune.html
     *
     * @param
     */
    public static function metronicIcon($icon, $iconClass = '', $svgClass = ''): string
    {
        $folder = substr($icon, 0, 3);

        $folder = match ($folder) {
            'ecm' => 'ecommerce',
            'lay' => 'layouts',
            'com' => 'communication',
            'gen' => 'general',
            'teh' => 'technology',
            'art' => 'art',
            'txt' => 'text',
            'abs' => 'abstract',
            'arr' => 'arrows',
            'fil' => 'files',
            'soc' => 'social',
            'gra' => 'graphs',
            'elc' => 'electronics',
            'med' => 'medicine',
            'map' => 'maps',
            'fin' => 'finance',
            'cod' => 'coding',
        };

        $path = "images/icons/duotune/$folder/$icon.svg";

        if (! File::exists($path)) {
            return '<!-- SVG file not found: '.$path.' -->';
        }

        $svg_content = file_get_contents($path);

        $dom = new DOMDocument();
        $dom->loadXML($svg_content);

        // remove unwanted comments
        $xpath = new DOMXPath($dom);
        foreach ($xpath->query('//comment()') as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // add class to svg
        if (! empty($svgClass)) {
            foreach ($dom->getElementsByTagName('svg') as $element) {
                $element->setAttribute('class', $svgClass);
            }
        }

        // remove unwanted tags
        $title = $dom->getElementsByTagName('title');
        if ($title['length']) {
            $dom->documentElement->removeChild($title[0]);
        }

        $desc = $dom->getElementsByTagName('desc');
        if ($desc['length']) {
            $dom->documentElement->removeChild($desc[0]);
        }

        $defs = $dom->getElementsByTagName('defs');
        if ($defs['length']) {
            $dom->documentElement->removeChild($defs[0]);
        }

        // remove unwanted id attribute in g tag
        $g = $dom->getElementsByTagName('g');
        foreach ($g as $el) {
            $el->removeAttribute('id');
        }

        $mask = $dom->getElementsByTagName('mask');
        foreach ($mask as $el) {
            $el->removeAttribute('id');
        }

        $rect = $dom->getElementsByTagName('rect');
        foreach ($rect as $el) {
            $el->removeAttribute('id');
        }

        $path = $dom->getElementsByTagName('path');
        foreach ($path as $el) {
            $el->removeAttribute('id');
        }

        $circle = $dom->getElementsByTagName('circle');
        foreach ($circle as $el) {
            $el->removeAttribute('id');
        }

        $use = $dom->getElementsByTagName('use');
        foreach ($use as $el) {
            $el->removeAttribute('id');
        }

        $polygon = $dom->getElementsByTagName('polygon');
        foreach ($polygon as $el) {
            $el->removeAttribute('id');
        }

        $ellipse = $dom->getElementsByTagName('ellipse');
        foreach ($ellipse as $el) {
            $el->removeAttribute('id');
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = ['svg-icon'];

        if (! empty($iconClass)) {
            $cls = array_merge($cls, explode(' ', $iconClass));
        }

        return "<span class='".implode(' ', $cls)."'>".$string.'</span>';
    }
}
