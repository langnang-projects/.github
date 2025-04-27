import request from "@/plugins/axios";

export const get_kugou_toplist = () => {
  return request({
    method: "get",
    url: "music.kugou/rank/list&json=true"
  });
};
