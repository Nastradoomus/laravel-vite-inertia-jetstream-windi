import axiosError from "./errors"

export const axios = async (url) => {
	try {
		const response = await window.axios.get(url)
		return response.data
	} catch (error) {
		axiosError(200, error)
		return false
	}
}

export const axiosPost = async (request) => {
	try {
		const response = await window.axios.post(request.url, request.json, {
			headers: {
				"Content-Type": "application/json"
			}
		})
		return response.data
	} catch (error) {
		axiosError(200, error)
		return false
	}
}

export const axiosDelete = async (request) => {
	try {
		const response = await window.axios.delete(request.url, {
			data: { id: request.id }
		})
		return response.data
	} catch (error) {
		axiosError(200, error)
		return false
	}
}
