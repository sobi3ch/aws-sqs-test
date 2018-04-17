FROM php:7.2-apache

COPY credentials /.aws/credentials

RUN chgrp -R www-data /.aws && \
    chmod 644 /.aws/credentials
