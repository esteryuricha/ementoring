<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/renderer.php' );

class theme_moodio_core_course_renderer extends core_course_renderer {
    /**
     * Renders HTML to display one course module in a course section
     *
     * This includes link, content, availability, completion info and additional information
     * that module type wants to display (i.e. number of unread forum posts)
     *
     * @deprecated since 4.0 MDL-72656 - use core_course output components instead.
     *
     * @param stdClass $course
     * @param completion_info $completioninfo
     * @param cm_info $mod
     * @param int|null $sectionreturn
     * @param array $displayoptions
     * @return string
     */
    /*
    public function course_section_cm($course, &$completioninfo, cm_info $mod, $sectionreturn, $displayoptions = []) {

        debugging(
            'course_section_cm is deprecated. Use core_courseformat\output\content\cm output classes instead.',
            DEBUG_DEVELOPER
        );

        if (!$mod->is_visible_on_course_page()) {
            return '';
        }

        $format = course_get_format($course);
        print_r($format);
        // $modinfo = $format->get_fast_modinfo();
        // // Output renderers works only with real section_info objects.
        // if ($sectionreturn) {
        //     $format->set_section_number($sectionreturn);
        // }
        // $section = $modinfo->get_section_info($format->get_section_number());

        // $cmclass = $format->get_output_classname('content\\cm');
        // $cm = new $cmclass($format, $section, $mod, $displayoptions);
        // // The course outputs works with format renderers, not with course renderers.
        // $renderer = $format->get_renderer($this->page);
        // $data = $cm->export_for_template($renderer);
        // return $this->output->render_from_template('core_courseformat/local/content/cm', $data);
    }
    */
}