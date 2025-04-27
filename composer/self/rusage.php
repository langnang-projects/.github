<?php

$resourceUsage = \getrusage();

// var_dump($_SERVER);

print_r($resourceUsage);

// echo "User time: " . $resourceUsage['ru_utime.tv_sec'] . " seconds\n";
// echo "System time: " . $resourceUsage['ru_stime.tv_sec'] . " seconds\n";
// echo "Maximum resident set size: " . $resourceUsage['ru_maxrss'] . " kilobytes\n";
// echo "Integral shared memory size: " . $resourceUsage['ru_ixrss'] . " kilobytes\n";
// echo "Integral unshared data size: " . $resourceUsage['ru_idrss'] . " kilobytes\n";
// echo "Integral unshared stack size: " . $resourceUsage['ru_isrss'] . " kilobytes\n";
// echo "Page reclaims (soft page faults): " . $resourceUsage['ru_minflt'] . " times\n";
// echo "Page faults (hard page faults): " . $resourceUsage['ru_majflt'] . " times\n";
// echo "Swaps: " . $resourceUsage['ru_nswap'] . " times\n";
// echo "Block input operations: " . $resourceUsage['ru_inblock'] . " blocks\n";
// echo "Block output operations: " . $resourceUsage['ru_oublock'] . " blocks\n";
// echo "Messages sent: " . $resourceUsage['ru_msgsnd'] . " messages\n";
// echo "Messages received: " . $resourceUsage['ru_msgrcv'] . " messages\n";
// echo "Signals delivered: " . $resourceUsage['ru_nsignals'] . " signals\n";
// echo "Voluntary context switches: " . $resourceUsage['ru_nvcsw'] . " switches\n";
// echo "Involuntary context switches: " . $resourceUsage['ru_nivcsw'] . " switches\n";
