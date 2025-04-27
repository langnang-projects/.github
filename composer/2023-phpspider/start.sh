#!/bin/bash
# 启动爬虫脚本

echo "脚本启动..."
# 请求 爬虫配置 接口，查询所有排队中的任务
# 模式
mode=$1
# 环境
env=$2
# 服务地址
server=$3

# echo "请求接口 '/crawler/list'：查询所有排队中的任务"

# res=$(curl -H "Content-Type: application/json" -s -X POST -d '{"status":1}' $server/crawler/list)
#  id=$(cat $FILE_PATH | ${JQ_EXEC} .menu.id | sed 's/\"//g')
# echo $res | jq
# echo $res | jq .status
workdir=$(cd $(dirname $0); pwd)

echo $workdir

list=$(cat $workdir/task.json)

# echo $list

length=$(echo $list | jq 'length')

echo "解析数据..."

for i in $(seq 0 $(expr $length - 1))
do

    # echo $i
    status=$(echo $list | jq .[$i].status)
    
    if [ "$status" = '"to start"' ];then
        
        echo "准备启动任务"
    
        id=$(echo $list | jq .[$i].id)
        key=$(echo $list | jq .[$i].key)
        # echo $id
        
        echo "准备启动任务 $id：$key"

        screen_name=$(echo PhpSpider.$key)
        
        # echo $screen_name
        
        if ! screen -list | grep -q $screen_name; then
            screen -dmS $screen_name
        fi
        
        cmd=$"php $workdir/main.php start mode=default id=$id env=$env";
        
        screen -x -S $screen_name -p 0 -X stuff "$cmd"
        screen -x -S $screen_name -p 0 -X stuff $'\n'
    fi

done

# echo $($list | jq [0].id)

# res_status=$(echo $res | jq .status)
# echo '状态码为：'$res_status
# res_statusText=$(echo $res | jq .statusText)
# echo '状态为：'$res_statusText
# res_data_total=$(echo $res | jq .data.total)
# echo '任务总数为：'$res_data_total

# res_data=$(echo $res | jq .data)
# # echo '返回数据为：'$res_data

# config=jq . './../php/phpspider/movie_douban_com.json'
# config=$res | jq .data.rows['0']
#     # echo $(php ./../php/phpspider/index.php start $res | jq .data.rows[$i])

# echo $config
# php './../php/phpspider/index.php' start $config
# if [ $res_data_total -gt '0' ];then
#     echo '存在需要执行的任务'
#     for i in $(seq 0 $(expr $res_data_total - 1))
#     do
#     # echo $(expr $i);
#     id=$(echo $res | jq .data.rows[$i].id)
#     slug=$(echo $res | jq .data.rows[$i].slug)

#     # 检测别名key(表名)是否设置
#     if [ "$slug" = "null" ];then
#         echo "取消任务$id：任务别名为空"
#         continue

#     fi

#     echo "准备启动任务 $id：$slug"

#     screen_name=$"PhpSpider.$slug"

#     if ! screen -list | grep -q $screen_name; then
#         screen -dmS $screen_name
#     fi

#     echo "开始执行任务$screen_name"

#     workdir=$(cd $(dirname $0); pwd)

#     cmd=$"php $workdir/index.php start $id $mode $env $server";

#     screen -x -S $screen_name -p 0 -X stuff "$cmd"
#     screen -x -S $screen_name -p 0 -X stuff $'\n'
#     # echo ':'$(echo $res | python -c 'import sys, json; print(json.load(sys.stdin)["data"]["rows"]['$i']["slug"])')
#     done
#     # task=$(php ./../php/phpspider/index.php start)
#     # echo $task
# fi
# # result=$res

# echo $result

# php ./../php/phpspider/index.php start

