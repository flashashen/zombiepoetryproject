package flash.zombie.nlp;

import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;
import org.springframework.ui.Model;


@Controller
@EnableAutoConfiguration
class ZombieTransform {



    @ModelAttribute("transformation")
    public Incident getTransformation(){
        return new Incident();
    }

//    @RequestMapping("/master")
//    @ResponseBody
//    String master() {
//        return
//                zombieMasterText;
//    }

//
//    @RequestMapping("/master/select")
//    @ResponseBody
//    String master(String tregex) {
//        return
//                zombieMasterText;
//    }

    @ModelAttribute
    public Incident transformation(@RequestParam(required=false) String text) {
        Incident transformation = new Incident();
        transformation.victimText = text;
        return transformation;
    }


    @RequestMapping(value="/victim"/*,  method= RequestMethod.POST*/)
//    @ResponseBody
    public String victim(
            Incident transformation, Model model) {

        if (transformation.victimText == null) return "victim";

        transformation.zombieText = progenitor.attack(transformation.victimText);
        model.addAttribute("transformation", transformation);

        // Return name of view to render
        return "victim";
    }




    private Progenitor progenitor;

    private void init() {
        progenitor = new Progenitor();
    }

    public ZombieTransform() {
        init();
    }



}