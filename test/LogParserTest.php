<?php
/**
 * WebLabz LLC
 * User: lance
 * Date: 12/6/13
 * Time: 5:46 PM
 */

namespace Weblabz\Test;

require_once __DIR__ .'/BaseTest.php';
use Weblabz\Scrapyd\LogParser;
class LogParserTest extends BaseTest {

    private $log_parser;

    public function setUp(){
        $this->log_parser = new LogParser();
    }

    public function testExtractErrors(){
        $errors = $this->log_parser->extractErrors($this->log);
        $this->assertEquals(7, sizeof($errors));
    }

    public function testExtractStats(){
        $stats = $this->log_parser->extractStats($this->log);
        $this->assertEquals($stats, $this->stats);
    }

    public function testExtractStatsJson(){
        $stats = $this->log_parser->extractStatsJson($this->log);
        $this->assertEquals($stats, json_decode($this->stats_json));
    }

    public function testGetStatsDates(){
        $start_date = $this->log_parser->getStatsDate([2013, 12, 6, 23, 31, 48]);
        $this->assertEquals($start_date, '2013-12-06 23:31:48');
    }


    private $stats = <<<EOT
{'downloader/request_bytes': 3380,
	 'downloader/request_count': 10,
	 'downloader/request_method_count/GET': 10,
	 'downloader/response_bytes': 11668,
	 'downloader/response_count': 10,
	 'downloader/response_status_count/200': 10,
	 'finish_reason': 'finished',
	 'finish_time': datetime.datetime(2013, 12, 6, 23, 31, 49, 119298),
	 'log_count/DEBUG': 16,
	 'log_count/ERROR': 7,
	 'log_count/INFO': 3,
	 'response_received_count': 10,
	 'scheduler/dequeued': 10,
	 'scheduler/dequeued/memory': 10,
	 'scheduler/enqueued': 10,
	 'scheduler/enqueued/memory': 10,
	 'spider_exceptions/IndexError': 7,
	 'start_time': datetime.datetime(2013, 12, 6, 23, 31, 48, 866452)}
EOT;

    private $stats_json = <<<EOT
{"downloader/request_bytes": 3380,
	 "downloader/request_count": 10,
	 "downloader/request_method_count/GET": 10,
	 "downloader/response_bytes": 11668,
	 "downloader/response_count": 10,
	 "downloader/response_status_count/200": 10,
	 "finish_reason": "finished",
	 "finish_time": "2013-12-06 23:31:49",
	 "log_count/DEBUG": 16,
	 "log_count/ERROR": 7,
	 "log_count/INFO": 3,
	 "response_received_count": 10,
	 "scheduler/dequeued": 10,
	 "scheduler/dequeued/memory": 10,
	 "scheduler/enqueued": 10,
	 "scheduler/enqueued/memory": 10,
	 "spider_exceptions/IndexError": 7,
	 "start_time": "2013-12-06 23:31:48"}
EOT;

    private $log = <<<EOT
2013-12-06 16:31:48-0700 [scrapy] INFO: Scrapy 0.20.1 started (bot: probatecollector)
2013-12-06 16:31:48-0700 [scrapy] DEBUG: Optional features available: ssl, http11
2013-12-06 16:31:48-0700 [scrapy] DEBUG: Overridden settings: {'NEWSPIDER_MODULE': 'probatecollector.spiders', 'FEED_URI': 'items/testProject/alameda/52a25e616bbf3.jl', 'DUPEFILTER_CLASS': 'scrapy.dupefilter.BaseDupeFilter', 'SPIDER_MODULES': ['probatecollector.spiders'], 'BOT_NAME': 'probatecollector', 'LOG_FILE': 'logs/testProject/alameda/52a25e616bbf3.log'}
2013-12-06 16:31:48-0700 [scrapy] DEBUG: Enabled extensions: FeedExporter, LogStats, TelnetConsole, CloseSpider, WebService, CoreStats, SpiderState
2013-12-06 16:31:48-0700 [scrapy] DEBUG: Enabled downloader middlewares: HttpAuthMiddleware, DownloadTimeoutMiddleware, UserAgentMiddleware, RetryMiddleware, DefaultHeadersMiddleware, MetaRefreshMiddleware, HttpCompressionMiddleware, RedirectMiddleware, CookiesMiddleware, ChunkedTransferMiddleware, DownloaderStats
2013-12-06 16:31:48-0700 [scrapy] DEBUG: Enabled spider middlewares: HttpErrorMiddleware, OffsiteMiddleware, RefererMiddleware, UrlLengthMiddleware, DepthMiddleware
2013-12-06 16:31:48-0700 [scrapy] DEBUG: Enabled item pipelines: DuplicatePipeline, PublishPipeline, RedisStorePipeLine
2013-12-06 16:31:48-0700 [alameda] INFO: Spider opened
2013-12-06 16:31:48-0700 [alameda] INFO: Crawled 0 pages (at 0 pages/min), scraped 0 items (at 0 items/min)
2013-12-06 16:31:48-0700 [scrapy] DEBUG: Telnet console listening on 0.0.0.0:6023
2013-12-06 16:31:48-0700 [scrapy] DEBUG: Web service listening on 0.0.0.0:6080
2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687001> (referer: None)
2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687002> (referer: None)
2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687000> (referer: None)
2013-12-06 16:31:49-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687001>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-06 16:31:49-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687002>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-06 16:31:49-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687000>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687004> (referer: None)
2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687005> (referer: None)
2013-12-06 16:31:49-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687004>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-06 16:31:49-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687005>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687003> (referer: None)
2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687007> (referer: None)
2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687006> (referer: None)
2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687009> (referer: None)
2013-12-06 16:31:49-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687008> (referer: None)
2013-12-06 16:31:49-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687009>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-06 16:31:49-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP13687008>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-06 16:31:49-0700 [alameda] INFO: Closing spider (finished)
2013-12-06 16:31:49-0700 [alameda] INFO: Dumping Scrapy stats:
	{'downloader/request_bytes': 3380,
	 'downloader/request_count': 10,
	 'downloader/request_method_count/GET': 10,
	 'downloader/response_bytes': 11668,
	 'downloader/response_count': 10,
	 'downloader/response_status_count/200': 10,
	 'finish_reason': 'finished',
	 'finish_time': datetime.datetime(2013, 12, 6, 23, 31, 49, 119298),
	 'log_count/DEBUG': 16,
	 'log_count/ERROR': 7,
	 'log_count/INFO': 3,
	 'response_received_count': 10,
	 'scheduler/dequeued': 10,
	 'scheduler/dequeued/memory': 10,
	 'scheduler/enqueued': 10,
	 'scheduler/enqueued/memory': 10,
	 'spider_exceptions/IndexError': 7,
	 'start_time': datetime.datetime(2013, 12, 6, 23, 31, 48, 866452)}
2013-12-06 16:31:49-0700 [alameda] INFO: Spider closed (finished)";
EOT;

    private log2 = <<< EOT
2013-12-19 13:23:29-0700 [scrapy] INFO: Scrapy 0.20.1 started (bot: probatecollector)
2013-12-19 13:23:29-0700 [scrapy] DEBUG: Optional features available: ssl, http11
2013-12-19 13:23:29-0700 [scrapy] DEBUG: Overridden settings: {'NEWSPIDER_MODULE': 'probatecollector.spiders', 'FEED_URI': 'file://items/probatecollector/alameda/52b355bff1331.jl', 'DUPEFILTER_CLASS': 'scrapy.dupefilter.BaseDupeFilter', 'SPIDER_MODULES': ['probatecollector.spiders'], 'BOT_NAME': 'probatecollector', 'LOG_FILE': 'logs/probatecollector/alameda/52b355bff1331.log'}
2013-12-19 13:23:29-0700 [scrapy] DEBUG: Enabled extensions: FeedExporter, LogStats, TelnetConsole, CloseSpider, WebService, CoreStats, SpiderState
2013-12-19 13:23:29-0700 [scrapy] DEBUG: Enabled downloader middlewares: HttpAuthMiddleware, DownloadTimeoutMiddleware, UserAgentMiddleware, RetryMiddleware, DefaultHeadersMiddleware, MetaRefreshMiddleware, HttpCompressionMiddleware, RedirectMiddleware, CookiesMiddleware, ChunkedTransferMiddleware, DownloaderStats
2013-12-19 13:23:29-0700 [scrapy] DEBUG: Enabled spider middlewares: HttpErrorMiddleware, OffsiteMiddleware, RefererMiddleware, UrlLengthMiddleware, DepthMiddleware
2013-12-19 13:23:29-0700 [scrapy] DEBUG: Enabled item pipelines: PublishPipeline, DuplicatePipeline, RedisStorePipeLine
2013-12-19 13:23:29-0700 [alameda] INFO: Spider opened
2013-12-19 13:23:29-0700 [alameda] ERROR: Error caught on signal handler: <bound method ?.open_spider of <scrapy.contrib.feedexport.FeedExporter object at 0x2038390>>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/defer.py", line 1099, in _inlineCallbacks
	    result = g.send(result)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/core/engine.py", line 229, in open_spider
	    yield self.signals.send_catch_log_deferred(signals.spider_opened, spider=spider)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/signalmanager.py", line 23, in send_catch_log_deferred
	    return signal.send_catch_log_deferred(*a, **kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/signal.py", line 53, in send_catch_log_deferred
	    *arguments, **named)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/defer.py", line 139, in maybeDeferred
	    result = f(*args, **kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/xlib/pydispatch/robustapply.py", line 54, in robustApply
	    return receiver(*arguments, **named)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/feedexport.py", line 171, in open_spider
	    file = storage.open(spider)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/feedexport.py", line 75, in open
	    os.makedirs(dirname)
	  File "/home/lance/.virtualenvs/scrapyd/lib/python2.7/os.py", line 150, in makedirs
	    makedirs(head, mode)
	  File "/home/lance/.virtualenvs/scrapyd/lib/python2.7/os.py", line 157, in makedirs
	    mkdir(name, mode)
	exceptions.OSError: [Errno 13] Permission denied: '/probatecollector'

2013-12-19 13:23:29-0700 [alameda] INFO: Crawled 0 pages (at 0 pages/min), scraped 0 items (at 0 items/min)
2013-12-19 13:23:29-0700 [scrapy] DEBUG: Telnet console listening on 0.0.0.0:6023
2013-12-19 13:23:29-0700 [scrapy] DEBUG: Web service listening on 0.0.0.0:6080
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP15> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP17> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP16> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP20> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP18> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP21> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP22> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP15>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP17>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP16>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP20>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP18>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP21>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP22>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP23> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP26> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP25> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP24> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP23>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP27> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP26>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP25>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP24>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP27>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP28> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP28>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP29> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP29>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP34> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP31> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP32> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP30> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP34>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP33> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP31>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP32>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP30>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP33>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP36> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP35> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP36>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP35>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP38> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP37> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP41> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP39> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP40> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP38>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP37>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP41>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP39>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP40>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP42> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP43> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP42>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP43>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP48> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP47> (referer: None)
2013-12-19 13:23:30-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP46> (referer: None)
2013-12-19 13:23:30-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP48>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP44> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP45> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP47>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP46>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP44>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP45>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP50> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP49> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP50>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP49>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP51> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP55> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP51>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP52> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP53> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP54> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP55>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP52>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP53>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP54>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP56> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP57> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP56>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP57>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP61> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP59> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP62> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP60> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP58> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP61>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP59>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP62>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP60>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP58>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP64> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP64>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP63> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP63>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP66> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP66>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP65> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP65>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP67> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP67>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP69> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP68> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP69>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP68>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP70> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP71> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP70>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP71>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP73> (referer: None)
2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP72> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP73>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP72>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:31-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP74> (referer: None)
2013-12-19 13:23:31-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP74>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:32-0700 [alameda] DEBUG: Crawled (200) <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP19> (referer: None)
2013-12-19 13:23:32-0700 [alameda] ERROR: Spider error processing <GET http://apps.alameda.courts.ca.gov/domainweb/service?ServiceName=DomainWebService&TemplateName=jsp/complitgeneralinfo.html&CaseNbr=RP19>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/base.py", line 824, in runUntilCurrent
	    call.func(*call.args, **call.kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 638, in _tick
	    taskObj._oneWorkUnit()
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/task.py", line 484, in _oneWorkUnit
	    result = next(self._iterator)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 57, in <genexpr>
	    work = (callable(elem, *args, **named) for elem in iterable)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/defer.py", line 96, in iter_errback
	    yield next(it)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/offsite.py", line 23, in process_spider_output
	    for x in result:
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/referer.py", line 22, in <genexpr>
	    return (_set_referer(r) for r in result or ())
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/urllength.py", line 33, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/spidermiddleware/depth.py", line 50, in <genexpr>
	    return (r for r in result or () if _filter(r))
	  File "build/bdist.linux-x86_64/egg/probatecollector/spiders/alamedacounty.py", line 42, in parse

	exceptions.IndexError: list index out of range

2013-12-19 13:23:32-0700 [alameda] INFO: Closing spider (finished)
2013-12-19 13:23:32-0700 [alameda] ERROR: Error caught on signal handler: <bound method ?.close_spider of <scrapy.contrib.feedexport.FeedExporter object at 0x2038390>>
	Traceback (most recent call last):
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/defer.py", line 577, in _runCallbacks
	    current.result = callback(current.result, *args, **kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/core/engine.py", line 272, in <lambda>
	    spider=spider, reason=reason, spider_stats=self.crawler.stats.get_stats()))
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/signalmanager.py", line 23, in send_catch_log_deferred
	    return signal.send_catch_log_deferred(*a, **kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/utils/signal.py", line 53, in send_catch_log_deferred
	    *arguments, **named)
	--- <exception caught here> ---
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/twisted/internet/defer.py", line 139, in maybeDeferred
	    result = f(*args, **kw)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/xlib/pydispatch/robustapply.py", line 54, in robustApply
	    return receiver(*arguments, **named)
	  File "/home/lance/.virtualenvs/scrapyd/local/lib/python2.7/site-packages/scrapy/contrib/feedexport.py", line 177, in close_spider
	    slot = self.slot
	exceptions.AttributeError: 'FeedExporter' object has no attribute 'slot'

2013-12-19 13:23:32-0700 [alameda] INFO: Dumping Scrapy stats:
	{'downloader/request_bytes': 22252,
	 'downloader/request_count': 60,
	 'downloader/request_method_count/GET': 60,
	 'downloader/response_bytes': 24200,
	 'downloader/response_count': 60,
	 'downloader/response_status_count/200': 60,
	 'finish_reason': 'finished',
	 'finish_time': datetime.datetime(2013, 12, 19, 20, 23, 32, 740800),
	 'log_count/DEBUG': 66,
	 'log_count/ERROR': 62,
	 'log_count/INFO': 3,
	 'response_received_count': 60,
	 'scheduler/dequeued': 60,
	 'scheduler/dequeued/memory': 60,
	 'scheduler/enqueued': 60,
	 'scheduler/enqueued/memory': 60,
	 'spider_exceptions/IndexError': 60,
	 'start_time': datetime.datetime(2013, 12, 19, 20, 23, 29, 920871)}
2013-12-19 13:23:32-0700 [alameda] INFO: Spider closed (finished)
EOT;

} 