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
	 "finish_time": [2013, 12, 6, 23, 31, 49, 119298],
	 "log_count/DEBUG": 16,
	 "log_count/ERROR": 7,
	 "log_count/INFO": 3,
	 "response_received_count": 10,
	 "scheduler/dequeued": 10,
	 "scheduler/dequeued/memory": 10,
	 "scheduler/enqueued": 10,
	 "scheduler/enqueued/memory": 10,
	 "spider_exceptions/IndexError": 7,
	 "start_time": [2013, 12, 6, 23, 31, 48, 866452]}
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
} 