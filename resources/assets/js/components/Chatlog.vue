<template lang='html'>
	<div class="chat-log">
		<chat-message v-for="message in messages" :message="message"></chat-message>
	</div>
</template>

<script>
export default{
	data() {
		return {
			messages: [
				{
					message: "This is some message text 1",
					user: "Kigoy"
				},
				{
					message: "This is some message text 2",
					user: "Kigoy"
				}
			]
		}
	}
}

</script>

<style lang="css">
</style>>
	
</template>