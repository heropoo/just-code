# -*- coding: utf-8 -*-
import scrapy

from ss_free_account.items import SsFreeAccountItem

class SsfreeaccountSpider(scrapy.Spider):
    name = 'SsFreeAccount'
    allowed_domains = ['github.com']
    start_urls = ['https://github.com/Alvin9999/new-pac/wiki/ss%E5%85%8D%E8%B4%B9%E8%B4%A6%E5%8F%B7']

    def parse(self, response):
        #filename = 'page.html'
        #open(filename, 'w').write(str(response.body, encoding='utf-8'))

        item = SsFreeAccountItem()
        item['name'] = 'img1'
        item['pic_url'] = response.xpath('//*[@id="wiki-body"]/div/p[14]/img/@src').extract()[0]

        #todo 解析图片 保存字段 

        return item
