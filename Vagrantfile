Vagrant.configure("2") do |config|
  
	config.vm.box = "precise32"

	config.vm.define :web do |web|
		web.vm.provision :shell, :path => "bootstrap/bootstrap_web.sh"
		web.vm.network :forwarded_port, guest: 80, host: 8888, auto_correct: true
		web.vm.network :private_network, ip: "192.168.5.1"
  	end

	config.vm.define :db do |db|
		db.vm.provision :shell, :path => "bootstrap/bootstrap_db.sh"
		db.vm.network :forwarded_port, guest: 3306, host: 8889, auto_correct: true
		db.vm.network :private_network, ip: "192.168.5.2"
  	end

	config.vm.define :cdn do |cdn|
		cdn.vm.provision :shell, :path => "bootstrap/bootstrap_cdn.sh"
		cdn.vm.network :private_network, ip: "192.168.5.3"
  	end

end