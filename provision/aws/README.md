
#  AWS instance base provisioning
---

[ansible ec2 module](http://docs.ansible.com/ec2_module.html)

With dynamic instance creation a static ansible inventory file does not work. There are several 
methods to tell ansible about EC2 instances. Note: if instances are provisioned in same execution
as instance creation, then an inventory may not be necesary at all, since the instance ids will 
already be in scope during the provisioning step

- ec2 script to fetch (cached) inventory on the fly from aws api
- ansible CloudFormation support. Use Amazon formatted file to do all the creation and provising
- Vagrant ec2 module that brings up images and automatically generates an inventory file
- hard coded in inventory file (this would require hand-editing the inventory file after instance creation)


All scripts and config are currently confgured for us-west-2 only


### create a new EC2 instance
ansible-playbook -vvvv -i inv_new_hosts create_instance.yml

### terminate all EC2 instances
ansible-playbook -vvvv -i ec2.py terminate_ec2.yml 


# useful environment variables
    
    // tell ansible what the AWS creds are. This may not be necessary if default is setup.
    $ export AWS_ACCESS_KEY_ID='YOUR_AWS_API_KEY'
    $ export AWS_SECRET_ACCESS_KEY='YOUR_AWS_API_SECRET_KEY'
    
    // tell ansible how to dynamically generate inventory.
    $ export ANSIBLE_HOSTS=./aws/ec2.py 
    $ export EC2_INI_PATH=./aws/ec2.ini 


# aws cli  
[docs](http://aws.amazon.com/cli/)

aws is a command line tool provided by Amazon that interacts with cloud state. It is no used directly 
in this project but is useful for quick checks and comparison with the ec2.py script and with boto, 
which is a project that ansible ec2 plugin uses to do the same thing.

example commands:

$ aws ec2 describe-instances

$ aws ec2 start-instances --instance-ids i-20ca92d7
$ aws ec2 stop-instances --instance-ids i-20ca92d7

$ aws autoscaling help

