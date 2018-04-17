FROM centos:7

RUN yum -y update && \
    yum install -y epel-release && \
    yum install -y wget php-cli htop
