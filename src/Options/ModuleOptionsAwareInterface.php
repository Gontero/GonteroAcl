<?php
namespace GonteroAcl\Options;


interface ModuleOptionsAwareInterface
{

    /**
     * @param ModuleOptions $options
     * @return mixed|void
     */
    public function setModuleOptions(ModuleOptions $options);

    /**
     * @return ModuleOptions
     */
    public function getModuleOptions();

}