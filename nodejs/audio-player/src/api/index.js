import request from "@/plugins/axios";

export * from "./kugou";

const host = "https://3dqx3.sse.codesandbox.io/music.163";
export const get_toplist = () => {
  return request({
    method: "get",
    url: `${host}/toplist`
  });
};
export const get_playlist = id => {
  return request({
    method: "get",
    url: `${host}/playlist/detail`,
    params: {
      id
    }
  });
};
export const get_lyric = id => {
  return request({
    method: "get",
    url: `${host}/song/lyric`,
    params: { id }
  });
};
export const get_song = ids => {
  return request({
    method: "get",
    url: `${host}/song/detail`,
    params: {
      ids: ids.map(v => v.id).join(",")
    }
  });
};
export const get_song_url = ids => {
  return request({
    method: "get",
    url: `${host}/song/player/url`,
    params: {
      ids: ids.map(v => v.id).join(",")
    }
  });
};
export const get_playlist_catlist = () => {
  return request({
    method: "get",
    url: `${host}/playlist/catalogue`
  });
};

export const get_playlist_top = ({ cat = "全部", pageNum = 1 }) => {
  return request({
    method: "get",
    url: `${host}/playlist/list`,
    params: {
      cat,
      pageNum
    }
  });
};

export const get_artist_list = ({ type, area, pageNum }) => {
  return request({
    method: "get",
    url: `${host}/artist/list`,
    params: {
      initial: undefined,
      offset: (pageNum - 1) * 100,
      limit: 100,
      total: true,
      type: type,
      area: area
    }
  });
};

export const get_artist_top_songs = id => {
  return request({
    method: "get",
    url: `${host}/artist/top/song`,
    params: {
      id
    }
  });
};

export const link_api_server = () => {
  return request({
    method: "options",
    url: `${host}`
  });
};
