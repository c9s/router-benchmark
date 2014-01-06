# PHP Router Benchmark

php -v (with APC enabled)

    PHP 5.4.9-4ubuntu2.4 (cli) (built: Dec 12 2013 04:29:20) 
    Copyright (c) 1997-2012 The PHP Group
    Zend Engine v2.4.0, Copyright (c) 1998-2012 Zend Technologies

apache2 -v

    Server version: Apache/2.2.22 (Ubuntu)
    Server built:   Jul 12 2013 13:18:14

CPU

    16 Core
    Extended brand string: "Intel(R) Xeon(R) CPU           E5620  @ 2.40GHz"
    CLFLUSH instruction cache line size: 8
    Initial APIC ID: 3
    Hyper threading siblings: 32

RAM

    8GB

Apache prefork

    <IfModule mpm_prefork_module>
        StartServers         10
        MinSpareServers      10
        MaxSpareServers      30
        MaxClients          150
        MaxRequestsPerChild   0
    </IfModule>

## Response Time

### Symfony Routing

<img src="https://raw.github.com/c9s/router-benchmark/master/ab/ab_symfony.png"/>

### Phux

<img src="https://raw.github.com/c9s/router-benchmark/master/ab/ab_phux_ext.png"/>


## Requests per second

http://c9s.github.io/router-benchmark/
