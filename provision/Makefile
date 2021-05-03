deploy-staging:
	@ansible-playbook playbook.yml -t deploy --limit=staging --key-file=${SSH_KEY} -e "app_env=staging" --ask-vault-pass

install-staging:
	@ansible-playbook playbook.yml -t install --limit=staging --key-file=${SSH_KEY} --ask-vault-pass  -e "app_env=staging"


deploy-prod:
	@ansible-playbook playbook.yml -t deploy --limit=prod --key-file=${SSH_KEY} --ask-vault-pass

install-prod:
	@ansible-playbook playbook.yml -t install --limit=prod --key-file=${SSH_KEY}  --ask-vault-pass

supervisor:
	@ansible-playbook playbook2.yml --limit=staging -e "app_env=staging" -t supervisord   --ask-vault-pass
	@#ansible-playbook playbook2.yml -t print --limit=staging -e "app_env=staging"

