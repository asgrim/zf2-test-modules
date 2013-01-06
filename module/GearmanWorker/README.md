Gearman worker module
---------------------

To run worker:

```bash
$ chmod +x bin/worker.sh
$ bin/worker.sh
[13378] 2013-01-06 21:31:30   Started worker script
```

To use, go to another terminal:

```bash
$ gearman -f foo test
33% Complete
66% Complete
100% Complete
$ 
```

In the server you'll see something like:

```
[13378] 2013-01-06 21:31:30   Started worker script
[13378] 2013-01-06 21:31:31 [bar(H:jamesxps:61)]   Workload is: test
[13378] 2013-01-06 21:31:31 [bar(H:jamesxps:61)]   1 of 3...
[13378] 2013-01-06 21:31:32 [bar(H:jamesxps:61)]   2 of 3...
[13378] 2013-01-06 21:31:33 [bar(H:jamesxps:61)]   3 of 3...
[13378] 2013-01-06 21:31:34   Waiting for a new job
```


