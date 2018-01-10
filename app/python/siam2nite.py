# -*- coding: utf-8 -*-
import scrapy


class ImageSpider(scrapy.Spider):
    name = 'image'
    allowed_domains = ['siam2nite.com']
    start_urls = ['https://www.siam2nite.com/en/pictures/']

    def __init__(self, url=None, *args, **kwargs):
        super(ImageSpider, self).__init__(*args, **kwargs)
        self.start_urls = ['%s' % url]

    def parse(self, response):
        c = 0
        for img in response.css('div.album-gallery.album__grid > a::attr(href)').extract():
            c = 1
            yield {
                'imagePath': img
            }
        if(c == 0): print("error")
        else: print("finish")
