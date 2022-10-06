<?php

declare(strict_types=1);

namespace ShlinkioCliTest\Shlink\CLI\Command;

use Shlinkio\Shlink\CLI\Command\ShortUrl\ListShortUrlsCommand;
use Shlinkio\Shlink\TestUtils\CliTest\CliTestCase;

class ListShortUrlsTest extends CliTestCase
{
    /**
     * @test
     * @dataProvider provideFlagsAndOutput
     */
    public function generatesExpectedOutput(array $flags, string $expectedOutput): void
    {
        [$output] = $this->exec([ListShortUrlsCommand::NAME, ...$flags], ['no']);
        self::assertStringContainsString($expectedOutput, $output);
    }

    public function provideFlagsAndOutput(): iterable
    {
        // phpcs:disable Generic.Files.LineLength
        yield 'no flags' => [[], <<<OUTPUT
            +--------------------+---------------+-------------------------------------------+-----------------------------------------------------------------------------------------------------------+---------------------------+--------------+
            | Short Code         | Title         | Short URL                                 | Long URL                                                                                                  | Date created              | Visits count |
            +--------------------+---------------+-------------------------------------------+-----------------------------------------------------------------------------------------------------------+---------------------------+--------------+
            | ghi789             |               | http://example.com/ghi789                 | https://blog.alejandrocelaya.com/2019/04/27/considerations-to-properly-use-open-source-software-projects/ | 2019-01-01T00:00:30+00:00 | 0            |
            | custom             |               | http://doma.in/custom                     | https://shlink.io                                                                                         | 2019-01-01T00:00:20+00:00 | 0            |
            | def456             |               | http://doma.in/def456                     | https://blog.alejandrocelaya.com/2017/12/09/acmailer-7-0-the-most-important-release-in-a-long-time/       | 2019-01-01T00:00:10+00:00 | 2            |
            | custom-with-domain |               | http://some-domain.com/custom-with-domain | https://google.com                                                                                        | 2018-10-20T00:00:00+00:00 | 0            |
            | abc123             | My cool title | http://doma.in/abc123                     | https://shlink.io                                                                                         | 2018-05-01T00:00:00+00:00 | 3            |
            | ghi789             |               | http://doma.in/ghi789                     | https://shlink.io/documentation/                                                                          | 2018-05-01T00:00:00+00:00 | 2            |
            +--------------------+---------------+-------------------------------------------+---------------------------- Page 1 of 1 ------------------------------------------------------------------+---------------------------+--------------+
            OUTPUT];
        yield 'start date' => [['--start-date=2019-01'], <<<OUTPUT
            +------------+-------+---------------------------+-----------------------------------------------------------------------------------------------------------+---------------------------+--------------+
            | Short Code | Title | Short URL                 | Long URL                                                                                                  | Date created              | Visits count |
            +------------+-------+---------------------------+-----------------------------------------------------------------------------------------------------------+---------------------------+--------------+
            | ghi789     |       | http://example.com/ghi789 | https://blog.alejandrocelaya.com/2019/04/27/considerations-to-properly-use-open-source-software-projects/ | 2019-01-01T00:00:30+00:00 | 0            |
            | custom     |       | http://doma.in/custom     | https://shlink.io                                                                                         | 2019-01-01T00:00:20+00:00 | 0            |
            | def456     |       | http://doma.in/def456     | https://blog.alejandrocelaya.com/2017/12/09/acmailer-7-0-the-most-important-release-in-a-long-time/       | 2019-01-01T00:00:10+00:00 | 2            |
            +------------+-------+---------------------------+-------------------------------------------- Page 1 of 1 --------------------------------------------------+---------------------------+--------------+
            OUTPUT];
        yield 'end date' => [['-e 2018-12-01'], <<<OUTPUT
            +--------------------+---------------+-------------------------------------------+----------------------------------+---------------------------+--------------+
            | Short Code         | Title         | Short URL                                 | Long URL                         | Date created              | Visits count |
            +--------------------+---------------+-------------------------------------------+----------------------------------+---------------------------+--------------+
            | custom-with-domain |               | http://some-domain.com/custom-with-domain | https://google.com               | 2018-10-20T00:00:00+00:00 | 0            |
            | abc123             | My cool title | http://doma.in/abc123                     | https://shlink.io                | 2018-05-01T00:00:00+00:00 | 3            |
            | ghi789             |               | http://doma.in/ghi789                     | https://shlink.io/documentation/ | 2018-05-01T00:00:00+00:00 | 2            |
            +--------------------+---------------+----------------------------------- Page 1 of 1 ------------------------------+---------------------------+--------------+
            OUTPUT];
        yield 'start and end date' => [['-s 2018-06-20', '--end-date=2019-01-01T00:00:20+00:00'], <<<OUTPUT
            +--------------------+-------+-------------------------------------------+-----------------------------------------------------------------------------------------------------+---------------------------+--------------+
            | Short Code         | Title | Short URL                                 | Long URL                                                                                            | Date created              | Visits count |
            +--------------------+-------+-------------------------------------------+-----------------------------------------------------------------------------------------------------+---------------------------+--------------+
            | custom             |       | http://doma.in/custom                     | https://shlink.io                                                                                   | 2019-01-01T00:00:20+00:00 | 0            |
            | def456             |       | http://doma.in/def456                     | https://blog.alejandrocelaya.com/2017/12/09/acmailer-7-0-the-most-important-release-in-a-long-time/ | 2019-01-01T00:00:10+00:00 | 2            |
            | custom-with-domain |       | http://some-domain.com/custom-with-domain | https://google.com                                                                                  | 2018-10-20T00:00:00+00:00 | 0            |
            +--------------------+-------+-------------------------------------------+----------------------------- Page 1 of 1 -----------------------------------------------------------+---------------------------+--------------+
            OUTPUT];
        // phpcs:enable
    }
}
