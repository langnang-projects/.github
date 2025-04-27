import axios from './../plugins/axios';

export const get_anime_timeline = () => {
	return axios({
		method: 'get',
		url: 'https://3dqx3.sse.codesandbox.io/anime.bilibili/timeline',
	});
};

export const get_anime_indexes = (params) => {
	return axios({
		method: 'get',
		url: 'https://3dqx3.sse.codesandbox.io/anime.bilibili/indexes',
		params,
	});
};
