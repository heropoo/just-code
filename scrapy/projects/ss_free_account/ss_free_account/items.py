# -*- coding: utf-8 -*-

# Define here the models for your scraped items
#
# See documentation in:
# https://doc.scrapy.org/en/latest/topics/items.html

import scrapy


class SsFreeAccountItem(scrapy.Item):
    # define the fields for your item here like:
    name = scrapy.Field()
    pic_url = scrapy.Field()
