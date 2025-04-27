import request from './../plugins/axios';

const host = '';

export const get_cupfox_command = (params) => {
	return request({
		method: 'get',
		url: 'https://api.jackeriss.com/api/v1/recommend/',
		params: {
			subject: params.subject || 'movie_热门',
			page_start: params.page_start || 0,
			page_limit: params.page_limit || 48,
		},
	});
};
